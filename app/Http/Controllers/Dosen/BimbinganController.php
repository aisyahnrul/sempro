<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bimbingan;

class BimbinganController extends Controller
{
    public function dashboard()
    {
    $user = auth()->user();

    $dosen = $user->dosen()->firstOrFail();

    $bimbingan = Bimbingan::with([
            'mahasiswa',
            'mahasiswa.proposal'
        ])
        ->where('id_dosen', $dosen->id_dosen)
        ->get();

    return view('dosen.dashboard', compact('bimbingan'));
    }
    public function index() {
    $user = auth()->user();
    $dosen = $user->dosen()->firstOrFail();
    $bimbingan = Bimbingan::with([
        'mahasiswa',
        'mahasiswa.proposal'
    ])->where('id_dosen', $dosen->id_dosen)->get();
    return view('dosen.bimbingan.index', compact('bimbingan'));
    }
    
}
