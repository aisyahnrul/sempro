<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Bimbingan;
use App\Models\Proposal;
use App\Models\ProposalVer;
use App\Models\Review;
use App\Models\StatusHistori;
use App\Models\Jadwal;
use App\Models\PengajuanGantiBimbingan;
use App\Models\RiwayatBimbingan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()  //nampilin daftar mahasiswa di halaman admin
    {
        $mahasiswa = Mahasiswa::with('user')->orderBy('nama')->get();
        return view('admin.mahasiswa.index', compact('mahasiswa')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() //nampilin form tmabah mahasiswa di halaman admin
    {
        return view('admin.mahasiswa.create');  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:mahasiswa,nim',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'username' => $validated['nim'],
                'password' => Hash::make('mhs12354'),
                'role' => 'mahasiswa',
            ]);

            Mahasiswa::create([
                'id_user' => $user->id_user,
                'nama' => $validated['nama'],
                'nim' => $validated['nim'],
            ]);
        });
        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          $mahasiswa = Mahasiswa::with('user')->findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:mahasiswa,nim,' . $mahasiswa->id_mhs . ',id_mhs',
            'password' => 'nullable|string|min:6',
        ]);

        DB::transaction(function () use ($mahasiswa, $validated) {

            $mahasiswa->update([
                'nama' => $validated['nama'],
                'nim' => $validated['nim'],
            ]);

            $userData = [
                'username' => $validated['nim'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $mahasiswa->user->update($userData);
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
        DB::transaction(function () use ($mahasiswa) {

        // Ambil semua proposal milik mahasiswa
        $proposalIds = Proposal::where('id_mhs', $mahasiswa->id_mhs)
            ->pluck('id_prop');

        // Ambil semua versi proposal
        $versiIds = ProposalVer::whereIn('id_prop', $proposalIds)
            ->pluck('id_ver');

        // Hapus review yang terkait versi proposal
        Review::whereIn('id_ver', $versiIds)->delete();

        // Hapus versi proposal
        ProposalVer::whereIn('id_prop', $proposalIds)->delete();

        // Hapus histori status proposal
        StatusHistori::whereIn('id_prop', $proposalIds)->delete();

        // Hapus jadwal proposal
        Jadwal::whereIn('id_prop', $proposalIds)->delete();

        // Hapus proposal
        Proposal::whereIn('id_prop', $proposalIds)->delete();

        // Hapus riwayat/pengajuan pergantian dosen
        PengajuanGantiBimbingan::where('id_mhs', $mahasiswa->id_mhs)->delete();

        RiwayatBimbingan::where('id_mhs', $mahasiswa->id_mhs)->delete();

        // Hapus data bimbingan
        Bimbingan::where('id_mhs', $mahasiswa->id_mhs)->delete();

        // Simpan user untuk ikut dihapus
        $user = $mahasiswa->user;

        // Hapus mahasiswa
        $mahasiswa->delete();

        // Hapus akun user
        if ($user) {
            $user->delete();
        }
    });

    return redirect()
        ->route('admin.mahasiswa.index')
        ->with('success', 'Data mahasiswa dan seluruh data terkait berhasil dihapus.');
    }

    public function resetPassword($id_mhs)
    {
    $mahasiswa = Mahasiswa::findOrFail($id_mhs);

    $mahasiswa->user->update([
        'password' => Hash::make('mhs12354'),
    ]);

    return redirect()
        ->route('admin.mahasiswa.index')
        ->with('success', 'Password mahasiswa berhasil direset ke mhs12354.');
    }
}
