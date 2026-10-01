<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Proposal;
use App\Models\StatusHistori;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
public function index()
{
    // Proposal yang belum dijadwalkan
    $proposal = Proposal::with([
        'mahasiswa',
        'jadwal',
    ])->where('status', 'Disetujui')
      ->orderByDesc('id_prop')
      ->get();

    // Proposal yang sudah memiliki jadwal
    $riwayat = Proposal::with([
        'mahasiswa',
        'jadwal',
    ])->where('status', 'Terjadwal')
      ->whereHas('jadwal')
      ->orderByDesc('id_prop')
      ->get();

    return view('admin.jadwal.index', compact('proposal', 'riwayat'));
}

    public function create($id)
    {
        $proposal = Proposal::with('mahasiswa')->where('status', 'Disetujui')->findOrFail($id);
        return view('admin.jadwal.create', compact('proposal'));
    }

    public function store(Request $request, $id)
    {
        $proposal = Proposal::findOrFail($id);

        // Pastikan hanya proposal yang sudah disetujui
        // yang dapat dijadwalkan.
        if ($proposal->status !== 'Disetujui') {
            return redirect()
                ->route('admin.jadwal.index')
                ->with('error', 'Proposal belum disetujui dan belum dapat dijadwalkan.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'ruang' => 'required|string|max:50',
        ]);

        DB::transaction(function () use ($proposal, $validated) {

            Jadwal::create([
                'id_prop' => $proposal->id_prop,
                'tanggal' => $validated['tanggal'],
                'waktu' => $validated['waktu'],
                'ruang' => $validated['ruang'],
                'created_by' => auth()->id(),
            ]);

            $proposal->update([
                'status' => 'Terjadwal',
            ]);

            StatusHistori::create([
                'id_prop' => $proposal->id_prop,
                'status' => 'Terjadwal',
                'changed_by' => auth()->id(),
                'changed_at' => now(),
                'note' => 'Seminar proposal telah dijadwalkan.',
            ]);
        });

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal Sempro berhasil dibuat.');
    }
}
