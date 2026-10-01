<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\ProposalVer;
use App\Models\Mahasiswa;
use App\Models\StatusHistori;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
{
    public function index(){
        $mahasiswa = Mahasiswa::where('id_user', auth()->id())
            ->firstOrFail();

        $proposal = $mahasiswa->proposal()
            ->with([
                'proposalVer.reviews',
                'statusHistori',
                'jadwal'
            ])
            ->latest()
            ->first();

        return view('mahasiswa.proposal.index', compact('proposal'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::where('id_user', auth()->id())
            ->firstOrFail();
        if (!$mahasiswa->bimbingan()->exists()){
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Dosen Pembimbing belum ditentukan oleh Prodi.');
        }
        // Satu mahasiswa hanya boleh punya satu proposal
        if ($mahasiswa->proposal()->exists()) {
            return redirect()
                ->route('mahasiswa.proposal.index')
                ->with('error', 'Anda sudah memiliki pengajuan proposal.');
        }

        return view('mahasiswa.proposal.create');
    }

    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::where('id_user', auth()->id())
            ->firstOrFail();
        if (!$mahasiswa->bimbingan()->exists()){
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Dosen Pembimbing belum ditentukan oleh Prodi.');
        }

        // Cegah mahasiswa membuat proposal kedua
        if ($mahasiswa->proposal()->exists()) {
            return redirect()
                ->route('mahasiswa.proposal.index')
                ->with('error', 'Anda sudah memiliki pengajuan proposal.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file_proposal' => 'required|file|mimes:pdf|max:10240',
        ]);

        $filePath = $request->file('file_proposal')
            ->store('proposals', 'public');

        DB::transaction(function () use (
            $mahasiswa,
            $validated,
            $filePath
        ) {
            // 1. Buat proposal
            $proposal = Proposal::create([
                'id_mhs' => $mahasiswa->id_mhs,
                'judul' => $validated['judul'],
                'status' => 'Diajukan',
            ]);

            // 2. Simpan versi pertama proposal
            ProposalVer::create([
                'id_prop' => $proposal->id_prop,
                'versi' => 1,
                'file_path' => $filePath,
                'upload_by' => auth()->id(),
                'uploaded_at' => now(),
            ]);

            // 3. Simpan histori status
            StatusHistori::create([
                'id_prop' => $proposal->id_prop,
                'status' => 'Diajukan',
                'changed_by' => auth()->id(),
                'changed_at' => now(),
                'note' => 'Pengajuan proposal awal.',
            ]);
        });

        return redirect()
            ->route('mahasiswa.proposal.index')
            ->with('success', 'Proposal berhasil diajukan.');
    }
public function revisi()
{
    $mahasiswa = Mahasiswa::where('id_user', auth()->id())
        ->firstOrFail();

    $proposal = $mahasiswa->proposal()
        ->with([
            'proposalVer.reviews.dosen',
            'statusHistori',
        ])
        ->first();

    if (!$proposal) {
        return redirect()
            ->route('mahasiswa.proposal.index')
            ->with('error', 'Anda belum memiliki proposal.');
    }

    $versiProposal = $proposal->proposalVer()
        ->with(['reviews.dosen'])
        ->orderBy('versi')
        ->get();

    return view('mahasiswa.proposal.revisi', compact(
        'proposal',
        'versiProposal'
    ));
}
    public function uploadRevisi(Request $request)
    {
    $mahasiswa = Mahasiswa::where('id_user', auth()->id())->firstOrFail();

    $proposal = $mahasiswa->proposal()->firstOrFail();

    if ($proposal->status !== 'Revisi') {
        return redirect()
            ->route('mahasiswa.proposal.index')
            ->with('error', 'Proposal belum dapat direvisi.');
    }

    $validated = $request->validate([
        'file_proposal' => 'required|file|mimes:pdf|max:10240',
    ]);

    $filePath = $request->file('file_proposal')
        ->store('proposals', 'public');

    $versiTerbaru = $proposal->proposalVer()
        ->orderByDesc('versi')
        ->first();

    $versiBaru = $versiTerbaru
        ? $versiTerbaru->versi + 1
        : 1;

    DB::transaction(function () use (
        $proposal,
        $filePath,
        $versiBaru
    ) {
        ProposalVer::create([
            'id_prop' => $proposal->id_prop,
            'versi' => $versiBaru,
            'file_path' => $filePath,
            'upload_by' => auth()->id(),
            'uploaded_at' => now(),
        ]);

        $proposal->update([
            'status' => 'Ditinjau Ulang',
        ]);

        StatusHistori::create([
            'id_prop' => $proposal->id_prop,
            'status' => 'Ditinjau Ulang',
            'changed_by' => auth()->id(),
            'changed_at' => now(),
            'note' => 'Mahasiswa mengunggah proposal hasil revisi versi ' . $versiBaru . '.',
        ]);
    });

    return redirect()
        ->route('mahasiswa.proposal.index')
        ->with('success', 'Proposal revisi berhasil diunggah.');
    }

    public function jadwal()
    {
        $mahasiswa = Mahasiswa::where('id_user', auth()->id())->firstOrFail();

        $proposal = $mahasiswa->proposal()->with('jadwal')->first();

        return view('mahasiswa.jadwal.index', compact('proposal'));
    }
}
