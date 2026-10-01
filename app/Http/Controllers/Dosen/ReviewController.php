<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Proposal;
use Illuminate\Support\Facades\Storage;
use App\Models\Review;
use App\Models\StatusHistori;
use Illuminate\Support\Facades\DB;
use App\Models\ProposalVer;

class ReviewController extends Controller
{
    public function show($id)
    {
        $user = auth()->user();
        $dosen = $user->dosen()->firstOrFail();

        $proposal = Proposal::with([
            'mahasiswa',
            'proposalVer.reviews',
            'statusHistori',
        ])->findOrFail($id);

        $isBimbingan = $dosen->bimbingan()
            ->where('id_mhs', $proposal->id_mhs)
            ->exists();

        if (!$isBimbingan) {
            abort(403, 'Anda tidak memiliki akses ke proposal ini.');
        }

        $versiProposal = $proposal->proposalVer()->with(['reviews.dosen'])
            ->orderByDesc('versi')
            ->get();

        return view('dosen.review.show', compact(
            'proposal',
            'versiProposal'
        ));
    }
    public function file($id_ver)
{
    $user = auth()->user();
    $dosen = $user->dosen()->firstOrFail();

    $versiProposal = ProposalVer::with('proposal')
        ->findOrFail($id_ver);

    $proposal = $versiProposal->proposal;

    // Pastikan proposal milik mahasiswa bimbingan dosen
    $isBimbingan = $dosen->bimbingan()
        ->where('id_mhs', $proposal->id_mhs)
        ->exists();

    if (!$isBimbingan) {
        abort(403, 'Anda tidak memiliki akses ke proposal ini.');
    }

    if (!Storage::disk('public')->exists($versiProposal->file_path)) {
        abort(404, 'File proposal tidak ditemukan.');
    }

    return Storage::disk('public')->response(
        $versiProposal->file_path,
        'proposal-versi-' . $versiProposal->versi . '.pdf',
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline',
        ]
    );
}
    public function store(Request $request, $id)
{
    $user = auth()->user();
    $dosen = $user->dosen()->firstOrFail();

    $proposal = Proposal::with('mahasiswa')->findOrFail($id);

    // Pastikan proposal milik mahasiswa bimbingan dosen
    $isBimbingan = $dosen->bimbingan()
        ->where('id_mhs', $proposal->id_mhs)
        ->exists();

    if (!$isBimbingan) {
        abort(403, 'Anda tidak memiliki akses ke proposal ini.');
    }

    // Proposal hanya bisa direview pada status ini
    if (!in_array($proposal->status, ['Diajukan', 'Ditinjau Ulang'])) {
        return redirect()
            ->route('dosen.review.show', $proposal->id_prop)
            ->with('error', 'Proposal tidak dapat direview pada status saat ini.');
    }

    $validated = $request->validate([
        'action' => 'required|in:revisi,setuju',
        'komentar' => 'nullable|string|max:255',
    ]);

    // Jika dosen meminta revisi, komentar wajib diisi
    if (
        $validated['action'] === 'revisi' &&
        empty($validated['komentar'])
    ) {
        return back()
            ->withErrors([
                'komentar' => 'Komentar wajib diisi jika meminta revisi.'
            ])
            ->withInput();
    }

    // Ambil versi P$versiProposal
    $versiProposal = $proposal->proposalVer()->with(['reviews.dosen'])
        ->orderByDesc('versi')
        ->firstOrFail();

    DB::transaction(function () use (
        $proposal,
        $dosen,
        $versiProposal,
        $validated
    ) {

        // Simpan komentar jika ada
        if (!empty($validated['komentar'])) {
            Review::create([
                'id_ver' => $versiProposal->id_ver,
                'id_dosen' => $dosen->id_dosen,
                'komentar' => $validated['komentar'],
            ]);
        }

        // Tentukan status berdasarkan tombol yang dipilih
        if ($validated['action'] === 'revisi') {

            $status = 'Revisi';
            $note = 'Dosen meminta mahasiswa melakukan revisi.';

        } else {

            $status = 'Disetujui';
            $note = 'Proposal disetujui oleh dosen pembimbing.';
        }

        // Update status proposal
        $proposal->update([
            'status' => $status,
        ]);

        // Simpan histori status
        StatusHistori::create([
            'id_prop' => $proposal->id_prop,
            'status' => $status,
            'changed_by' => auth()->id(),
            'changed_at' => now(),
            'note' => $note,
        ]);
    });

    $pesan = $validated['action'] === 'revisi'
        ? 'Proposal dikembalikan untuk revisi.'
        : 'Proposal berhasil disetujui.';

    return redirect()
        ->route('dosen.review.show', $proposal->id_prop)
        ->with('success', $pesan);
}
}
