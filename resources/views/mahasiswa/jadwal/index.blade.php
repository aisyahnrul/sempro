@extends('layouts.app')
@section('title','Jadwal Sempro')
@section('page-title','Jadwal Sempro')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
@if (!$proposal)
    <div class="card empty-state"><h3>Belum ada proposal</h3><p>Jadwal sempro akan tersedia setelah proposal diajukan dan disetujui.</p></div>
@elseif (!$proposal->jadwal)
    <div class="card empty-state"><h3>Belum ada jadwal sempro</h3><p>Proposal Anda belum memiliki jadwal seminar proposal.</p><div class="form-actions" style="justify-content:center;"><a class="btn btn-outline" href="{{ route('mahasiswa.proposal.index') }}">Lihat Status Pengajuan</a></div></div>
@else
    <div class="card">
        <div class="card-head"><div><h3>{{ $proposal->judul }}</h3><p style="margin:4px 0 0;">Seminar proposal Anda telah dijadwalkan.</p></div>@include('partials.status-badge',['status'=>$proposal->status])</div>
        <div class="kv-grid-3">
            <div class="kv"><span class="k">Tanggal</span><span class="v">{{ $proposal->jadwal->tanggal?->format('d F Y') }}</span></div>
            <div class="kv"><span class="k">Waktu</span><span class="v">{{ substr($proposal->jadwal->waktu, 0, 5) }}</span></div>
            <div class="kv"><span class="k">Ruang</span><span class="v">{{ $proposal->jadwal->ruang }}</span></div>
        </div>
    </div>
@endif
@endsection
