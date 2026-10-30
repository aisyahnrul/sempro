<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bimbingan;
use App\models\Dosen;
use App\Models\Mahasiswa;
use App\Models\RiwayatBimbingan;
use App\Models\PengajuanGantiBimbingan;
use Illuminate\Support\Facades\DB;


class BimbinganController extends Controller
{
    public function index(Request $request) {
        $search = $request->search;

        $mahasiswa = Mahasiswa::with('bimbingan.dosen')->when($search, function ($query) use ($search){
            $query->where(function ($q) use ($search){
                $q->where('nama', 'like', "%{$search}%")->orwhere('nim', 'like', "%{$search}%");
            });
        })->orderBy('nama')->get();
        $dosen = Dosen::withCount('bimbingan')->orderBy('nama')->get();
        return view('admin.bimbingan.index', compact('mahasiswa', 'dosen'));
    }
    public function detail($id_mhs)
    {
        $mahasiswa = Mahasiswa::with('bimbingan.dosen')->findOrFail($id_mhs);

        $dosen = Dosen::orderBy('nama')->get();

        return view('admin.bimbingan.detail', compact('mahasiswa', 'dosen'));
    }
    public function gantiForm($id_mhs)
    {
    $mahasiswa = Mahasiswa::with('bimbingan.dosen')
        ->findOrFail($id_mhs);

    $bimbingan = $mahasiswa->bimbingan->first();

    if (!$bimbingan) {
        return redirect()
            ->route('admin.bimbingan.detail', $id_mhs)
            ->with('error', 'Mahasiswa belum memiliki dosen pembimbing.');
    }

    $dosen = Dosen::where('id_dosen', '!=', $bimbingan->id_dosen)
        ->orderBy('nama')
        ->get();

    $riwayat = RiwayatBimbingan::with([
            'dosenLama',
            'dosenBaru',
            'changedBy',
        ])
        ->where('id_mhs', $id_mhs)
        ->orderByDesc('changed_at')
        ->get();

    return view('admin.bimbingan.ganti', compact(
        'mahasiswa',
        'bimbingan',
        'dosen',
        'riwayat'
    ));
    }

    public function ganti(Request $request, $id_mhs)
    {
    $mahasiswa = Mahasiswa::with('bimbingan')
        ->findOrFail($id_mhs);

    $bimbingan = $mahasiswa->bimbingan->first();

    if (!$bimbingan) {
        return redirect()
            ->route('admin.bimbingan.detail', $id_mhs)
            ->with('error', 'Mahasiswa belum memiliki dosen pembimbing.');
    }

    $validated = $request->validate([
        'id_dosen' => 'required|exists:dosen,id_dosen',
        'alasan' => 'required|string|max:500',
    ]);

    if ((int) $validated['id_dosen'] === (int) $bimbingan->id_dosen) {
        return back()
            ->withErrors([
                'id_dosen' => 'Dosen baru harus berbeda dari dosen pembimbing saat ini.'
            ])
            ->withInput();
    }

    DB::transaction(function () use (
        $bimbingan,
        $validated,
        $id_mhs
    ) {
        RiwayatBimbingan::create([
            'id_mhs' => $id_mhs,
            'id_dosen_lama' => $bimbingan->id_dosen,
            'id_dosen_baru' => $validated['id_dosen'],
            'changed_by' => auth()->id(),
            'alasan' => $validated['alasan'],
            'changed_at' => now(),
            'sumber' => 'prodi',
        ]);

        $bimbingan->update([
            'id_dosen' => $validated['id_dosen'],
            'assigned_by' => auth()->id(),
        ]);
    });

    return redirect()
        ->route('admin.bimbingan.detail', $id_mhs)
        ->with('success', 'Dosen pembimbing berhasil diganti.');
    }
    public function pengajuanGanti()
    {
    $pengajuan = PengajuanGantiBimbingan::with([
            'mahasiswa',
            'dosenSaatIni',
            'dosenBaru',
        ])
        ->orderByDesc('created_at')
        ->get();

    return view(
        'admin.bimbingan.pengajuan_ganti',
        compact('pengajuan')
    );
    }
    public function prosesPengajuanGanti($id_pengajuan)
    {
    $pengajuan = PengajuanGantiBimbingan::with([
        'mahasiswa',
        'dosenSaatIni',
    ])->findOrFail($id_pengajuan);

    if ($pengajuan->status !== 'Diajukan') {
        return redirect()
            ->route('admin.bimbingan.pengajuan_ganti')
            ->with('error', 'Pengajuan ini sudah diproses.');
    }

    $dosen = Dosen::where(
        'id_dosen',
        '!=',
        $pengajuan->id_dosen_saat_ini
    )
        ->orderBy('nama')
        ->get();

    return view(
        'admin.bimbingan.proses_ganti',
        compact('pengajuan', 'dosen')
    );
    }
    public function setujuiPengajuanGanti(Request $request, $id_pengajuan)
    {
    $pengajuan = PengajuanGantiBimbingan::with('mahasiswa')
        ->findOrFail($id_pengajuan);

    if ($pengajuan->status !== 'Diajukan') {
        return back()->with('error', 'Pengajuan ini sudah diproses.');
    }

    $validated = $request->validate([
        'id_dosen_baru' => 'required|exists:dosen,id_dosen',
        'catatan_prodi' => 'nullable|string|max:1000',
    ]);

    if (
        (int) $validated['id_dosen_baru'] ===
        (int) $pengajuan->id_dosen_saat_ini
    ) {
        return back()
            ->withErrors([
                'id_dosen_baru' =>
                    'Dosen baru harus berbeda dari dosen saat ini.'
            ])
            ->withInput();
    }

    DB::transaction(function () use (
        $pengajuan,
        $validated
    ) {
        $bimbingan = Bimbingan::where(
            'id_mhs',
            $pengajuan->id_mhs
        )->first();

        if (!$bimbingan) {
            abort(
                422,
                'Mahasiswa belum memiliki dosen pembimbing aktif.'
            );
        }

        RiwayatBimbingan::create([
            'id_mhs' => $pengajuan->id_mhs,
            'id_dosen_lama' => $bimbingan->id_dosen,
            'id_dosen_baru' => $validated['id_dosen_baru'],
            'changed_by' => auth()->id(),
            'alasan' => $pengajuan->alasan,
            'changed_at' => now(),
            'sumber' => 'mahasiswa',
        ]);

        $bimbingan->update([
            'id_dosen' => $validated['id_dosen_baru'],
            'assigned_by' => auth()->id(),
        ]);

        $pengajuan->update([
            'id_dosen_baru' => $validated['id_dosen_baru'],
            'status' => 'Disetujui',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'catatan_prodi' => $validated['catatan_prodi'] ?? null,
        ]);
    });

    return redirect()
        ->route('admin.bimbingan.pengajuan_ganti')
        ->with(
            'success',
            'Pengajuan pergantian dosen berhasil disetujui dan dosen pembimbing telah diperbarui.'
        );
    }
    public function tolakPengajuanGanti(Request $request, $id_pengajuan)
    {
    $pengajuan = PengajuanGantiBimbingan::findOrFail($id_pengajuan);

    if ($pengajuan->status !== 'Diajukan') {
        return back()->with('error', 'Pengajuan ini sudah diproses.');
    }

    $validated = $request->validate([
        'catatan_prodi' => 'required|string|max:1000',
    ]);

    $pengajuan->update([
        'status' => 'Ditolak',
        'reviewed_by' => auth()->id(),
        'reviewed_at' => now(),
        'catatan_prodi' => $validated['catatan_prodi'],
    ]);

    return redirect()
        ->route('admin.bimbingan.pengajuan_ganti')
        ->with(
            'success',
            'Pengajuan pergantian dosen telah ditolak.'
        );
    }
    public function dosenDetail($id_dosen)
    {
        $dosen = Dosen::findOrFail($id_dosen);

        $bimbingan = $dosen->bimbingan()->with('mahasiswa.proposal')->orderBy('created_at')->get();

        return view('admin.bimbingan.dosen_detail', compact('dosen','bimbingan'));
    }
     public function store(Request $request)
    {
    $validated = $request->validate([
        'id_mhs' => 'required|exists:mahasiswa,id_mhs',
        'id_dosen' => 'required|exists:dosen,id_dosen',
    ]);

    DB::transaction(function () use ($validated) {

        $sudahAda = Bimbingan::where(
            'id_mhs',
            $validated['id_mhs']
        )->exists();

        if ($sudahAda) {
            abort(422, 'Mahasiswa sudah memiliki dosen pembimbing.');
        }

        Bimbingan::create([
            'id_mhs' => $validated['id_mhs'],
            'id_dosen' => $validated['id_dosen'],
            'assigned_by' => auth()->id(),
        ]);
    });

    return redirect()
        ->route('admin.bimbingan.index')
        ->with('success', 'Dosen pembimbing berhasil ditentukan.');
    }

}
