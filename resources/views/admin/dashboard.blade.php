@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
<div class="card">
    <div class="card-head">
        <div>
            <h3>Selamat datang di SIPOLAR</h3>
            <p style="margin:4px 0 0;">Kelola data, proses pengajuan, dan penjadwalan seminar proposal dalam satu sistem.</p>
        </div>
    </div>
</div>

<div class="grid-3 dashboard-cards">
    <a href="{{ route('admin.monitoring.index') }}" class="card shortcut-card">
        <h3>Monitoring Pengajuan</h3>
        <p>Pantau status setiap proposal mahasiswa.</p>
    </a>

    <a href="{{ route('admin.bimbingan.index') }}" class="card shortcut-card">
        <h3>Dosen Pembimbing</h3>
        <p>Tentukan pembimbing dan pantau beban bimbingan.</p>
    </a>

    <a href="{{ route('admin.jadwal.index') }}" class="card shortcut-card">
        <h3>Penjadwalan Sempro</h3>
        <p>Jadwalkan proposal yang telah disetujui.</p>
    </a>
</div>
@endsection
