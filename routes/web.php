<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\BimbinganController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Mahasiswa\ProposalController;
use App\Http\Controllers\Mahasiswa\PengajuanGantiBimbinganController;
use App\Http\Controllers\Dosen\BimbinganController as DosenBimbinganController;
use App\Http\Controllers\Dosen\ReviewController;
use App\Http\Controllers\PasswordController;

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dosen' => redirect()->route('dosen.dashboard'),
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            default => redirect()->route('login'),
        };
    }

    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/ubah-password', [PasswordController::class, 'edit'])
        ->name('password.edit');

    Route::put('/ubah-password', [PasswordController::class, 'update'])
        ->name('password.update');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
// Route::view('/dashboard', 'dashboard')->middleware('auth')->name('dashboard');
// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::view('/admin/dashboard', 'admin.dashboard')
        ->name('admin.dashboard');
    Route::resource('/admin/mahasiswa', MahasiswaController::class)->names('admin.mahasiswa');
    Route::put('/admin/mahasiswa/{id_mhs}/reset-password', [MahasiswaController::class, 'resetPassword'])
    ->name('admin.mahasiswa.reset-password');
    Route::resource('/admin/dosen', DosenController::class)->names('admin.dosen');
    Route::put('/admin/dosen/{id_dosen}/reset-password', [DosenController::class, 'resetPassword'])
    ->name('admin.dosen.reset-password');
    Route::get('/admin/bimbingan', [BimbinganController::class, 'index'])->name('admin.bimbingan.index');
    Route::get('/admin/bimbingan/{id_mhs}/detail', [BimbinganController::class, 'detail'])->name('admin.bimbingan.detail');
    Route::get('/admin/bimbingan/dosen/{id_dosen}', [BimbinganController::class, 'dosenDetail'])->name('admin.bimbingan.dosen_detail');
    Route::get('/admin/bimbingan/{id_mhs}/ganti', [BimbinganController::class, 'gantiForm'])
    ->name('admin.bimbingan.ganti');
    Route::put('/admin/bimbingan/{id_mhs}/ganti', [BimbinganController::class, 'ganti'])
    ->name('admin.bimbingan.ganti.store');
    Route::get(
    '/admin/bimbingan/pengajuan_ganti/{id_pengajuan}',
    [BimbinganController::class, 'prosesPengajuanGanti']
    )->name('admin.bimbingan.pengajuan_ganti.proses');

    Route::put(
        '/admin/bimbingan/pengajuan_ganti/{id_pengajuan}/setujui',
        [BimbinganController::class, 'setujuiPengajuanGanti']
    )->name('admin.bimbingan.pengajuan_ganti.setujui');

    Route::put(
        '/admin/bimbingan/pengajuan_ganti/{id_pengajuan}/tolak',
        [BimbinganController::class, 'tolakPengajuanGanti']
    )->name('admin.bimbingan.pengajuan_ganti.tolak');
    Route::post('/admin/bimbingan', [BimbinganController::class, 'store'])->name('admin.bimbingan.store');
    Route::get('/admin/monitoring', [MonitoringController::class, 'index'])
    ->name('admin.monitoring.index');
    Route::get('/admin/jadwal', [JadwalController::class, 'index'])->name('admin.jadwal.index');
    Route::get('/admin/jadwal/{id}/create', [JadwalController::class, 'create'])->name('admin.jadwal.create');
    Route::post('/admin/jadwal/{id}', [JadwalController::class, 'store'])->name('admin.jadwal.store');
    Route::get('/admin/bimbingan/pengajuan_ganti',[BimbinganController::class, 'pengajuanGanti'])->name('admin.bimbingan.pengajuan_ganti');
});


// Dashboard Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::view('/mahasiswa/dashboard', 'mahasiswa.dashboard')
        ->name('mahasiswa.dashboard');

    Route::get('/mahasiswa/proposal', [ProposalController::class, 'index'])
        ->name('mahasiswa.proposal.index');

    Route::get('/mahasiswa/proposal/create', [ProposalController::class, 'create'])
        ->name('mahasiswa.proposal.create');

    Route::post('/mahasiswa/proposal', [ProposalController::class, 'store'])
        ->name('mahasiswa.proposal.store');
    Route::get('/mahasiswa/proposal/revisi', [ProposalController::class, 'revisi'])
    ->name('mahasiswa.proposal.revisi');

    Route::post('/mahasiswa/proposal/revisi', [ProposalController::class, 'uploadRevisi'])
        ->name('mahasiswa.proposal.uploadRevisi');
    Route::get('/mahasiswa/jadwal', [ProposalController::class, 'jadwal'])
    ->name('mahasiswa.jadwal.index');
    Route::get('/mahasiswa/ganti-dosen',[PengajuanGantiBimbinganController::class, 'create'])->name('mahasiswa.bimbingan-ganti.create');    
    Route::post('/mahasiswa/ganti-dosen',[PengajuanGantiBimbinganController::class, 'store'])->name('mahasiswa.bimbingan-ganti.store');

});


// Dashboard Dosen
Route::middleware(['auth', 'role:dosen'])->group(function () {

    Route::get('/dosen/dashboard', [DosenBimbinganController::class, 'dashboard'])
        ->name('dosen.dashboard');
    Route::get('/dosen/bimbingan', [DosenBimbinganController::class, 'index'])->name('dosen.bimbingan.index');
    Route::get('/dosen/review/{id}', [ReviewController::class, 'show'])
    ->name('dosen.review.show');
    Route::get('/dosen/review/file/{id_ver}', [ReviewController::class, 'file'])
        ->name('dosen.review.file');    
    Route::post('/dosen/review/{id}', [ReviewController::class, 'store'])
    ->name('dosen.review.store');
});