<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\User;
use App\Models\Bimbingan;
use App\Models\Revisi;
use App\Models\RiwayatBimbingan;
use App\Models\PengajuanGantiBimbingan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosen = Dosen::with('user')->orderBy('nama')->get();
        return view('admin.dosen.index', compact('dosen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dosen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:dosen,nip',
            'nama' => 'required',
            'max_bimbingan' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'username' => $validated['nip'],
                'password' => Hash::make('dosen12354'),
                'role' => 'dosen',
            ]);

            Dosen::create([
                'id_user' => $user->id_user,
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'max_bimbingan' => $validated['max_bimbingan'],
            ]);
        });

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dosen = Dosen::with('user')->findOrFail($id);
        return view('admin.dosen.show', compact('dosen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dosen = Dosen::with('user')->findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dosen = Dosen::with('user')->findOrFail($id);

        $validated =$request->validate([
            'nip' => 'required|string|unique:dosen,nip,' . $dosen->id_dosen . ',id_dosen',
            'nama' => 'required |string| max: 100',
            'max_bimbingan' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($dosen, $validated) {
            $dosen->update([
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'max_bimbingan' => $validated['max_bimbingan'],
            ]);

            $dosen->user->update([
                'username' => $validated['nip'],
            ]);
        });

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dosen = Dosen::with('user')->findOrFail($id);

    if (Bimbingan::where('id_dosen', $id)->exists()) {
        return redirect()
            ->route('admin.dosen.index')
            ->with('error', 'Dosen tidak dapat dihapus karena masih memiliki mahasiswa bimbingan.');
    }

    if (Review::where('id_dosen', $id)->exists()) {
        return redirect()
            ->route('admin.dosen.index')
            ->with('error', 'Dosen tidak dapat dihapus karena masih memiliki riwayat review proposal.');
    }

    if (RiwayatBimbingan::where('id_dosen_lama', $id)
        ->orWhere('id_dosen_baru', $id)
        ->exists()) {
        return redirect()
            ->route('admin.dosen.index')
            ->with('error', 'Dosen tidak dapat dihapus karena masih memiliki riwayat pergantian dosen pembimbing.');
    }

    if (PengajuanGantiBimbingan::where('id_dosen_saat_ini', $id)
        ->orWhere('id_dosen_baru', $id)
        ->exists()) {
        return redirect()
            ->route('admin.dosen.index')
            ->with('error', 'Dosen tidak dapat dihapus karena masih terkait pengajuan pergantian dosen pembimbing.');
    }

    DB::transaction(function () use ($dosen) {
        $user = $dosen->user;

        $dosen->delete();

        if ($user) {
            $user->delete();
        }
    });

    return redirect()
        ->route('admin.dosen.index')
        ->with('success', 'Data dosen berhasil dihapus.');
    }
    public function resetPassword($id_dosen)
    {
    $dosen = Dosen::findOrFail($id_dosen);

    $dosen->user->update([
        'password' => Hash::make('dosen12354'),
    ]);

    return redirect()
        ->route('admin.dosen.index')
        ->with('success', 'Password dosen berhasil direset ke dosen12354.');
    }
    
}
