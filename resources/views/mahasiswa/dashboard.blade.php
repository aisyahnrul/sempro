@extends('layouts.app')
@section('title','Dashboard Mahasiswa')
@section('page-title','Dashboard')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
<div class="card">
    <div class="card-head"><div><h3>Selamat datang di SIPOLAR</h3><p style="margin:4px 0 0;">Kelola pengajuan proposal, pantau proses revisi, dan lihat informasi jadwal seminar Anda.</p></div></div>
</div>
<div class="grid-3 dashboard-cards">
    <a href="{{ route('mahasiswa.proposal.index') }}" class="card dashboard-card"><h3>Status Pengajuan</h3><p>Lihat posisi proposal pada setiap tahap proses.</p></a>
    <a href="{{ route('mahasiswa.proposal.revisi') }}" class="card dashboard-card"><h3>Komentar &amp; Revisi</h3><p>Lihat catatan dosen dan unggah hasil revisi ketika diminta.</p></a>
    <a href="{{ route('mahasiswa.jadwal.index') }}" class="card dashboard-card"><h3>Jadwal Sempro</h3><p>Lihat informasi jadwal seminar proposal setelah ditetapkan.</p></a>
</div>
@endsection
