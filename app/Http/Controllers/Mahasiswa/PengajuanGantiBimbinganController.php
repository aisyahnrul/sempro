<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\PengajuanGantiBimbingan;
use Illuminate\Http\Request;

class PengajuanGantiBimbinganController extends Controller
{
    public function create()
    {
        $mahasiswa = Mahasiswa::with('bimbingan.dosen')
            ->where('id_user', auth()->id())
            ->firstOrFail();

        $bimbingan = $mahasiswa->bimbingan->first();

        if (!$bimbingan) {
            return redirect()
                ->route('mahasiswa.dashboard')
                ->with(
                    'error',
                    'Dosen pembimbing Anda belum ditentukan.'
                );
        }

        $pengajuanAktif = PengajuanGantiBimbingan::where('id_mhs', $mahasiswa->id_mhs)
            ->where('status', 'Diajukan')
            ->exists();
        $riwayat = PengajuanGantiBimbingan::with([
        'dosenSaatIni',
        'dosenBaru',
        ])
        ->where('id_mhs', $mahasiswa->id_mhs)
        ->orderByDesc('created_at')
        ->get();

        return view(
            'mahasiswa.bimbingan-ganti.create',
            compact('mahasiswa', 'bimbingan', 'pengajuanAktif', 'riwayat')
        );
    }

    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::with('bimbingan')
            ->where('id_user', auth()->id())
            ->firstOrFail();

        $bimbingan = $mahasiswa->bimbingan->first();

        if (!$bimbingan) {
            return back()
                ->with('error', 'Dosen pembimbing belum ditentukan.');
        }

        $masihAda = PengajuanGantiBimbingan::where('id_mhs', $mahasiswa->id_mhs)
            ->where('status', 'Diajukan')
            ->exists();

        if ($masihAda) {
            return back()
                ->with('error', 'Pengajuan pergantian dosen masih menunggu diproses oleh Prodi.');
        }

        $validated = $request->validate([
            'alasan' => 'required|string|max:1000',
        ]);

        PengajuanGantiBimbingan::create([
            'id_mhs' => $mahasiswa->id_mhs,
            'id_dosen_saat_ini' => $bimbingan->id_dosen,
            'alasan' => $validated['alasan'],
            'status' => 'Diajukan',
        ]);

        return redirect()
            ->route('mahasiswa.bimbingan-ganti.create')
            ->with('success', 'Pengajuan pergantian dosen berhasil dikirim.');
    }
}