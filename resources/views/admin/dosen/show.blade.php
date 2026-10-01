@extends('layouts.app')
@section('title','Detail Dosen')
@section('page-title','Detail Dosen')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
<div class="card" style="max-width:760px;">
    <div class="card-head"><h3>{{ $dosen->nama }}</h3><span class="badge status-purple"><span class="dot"></span>Dosen Pembimbing</span></div>
        <div class="kv"><span class="k">NIP</span><span class="v">{{ $dosen->nip }}</span></div>
        <div class="kv"><span class="k">Username</span><span class="v">{{ $dosen->user->username }}</span></div>
        <div class="kv"><span class="k">Maksimal Bimbingan</span><span class="v">{{ $dosen->max_bimbingan }} mahasiswa</span></div>
    <div class="form-actions"><a class="btn btn-outline" href="{{ route('admin.dosen.index') }}">← Kembali</a><a class="btn btn-primary" href="{{ route('admin.dosen.edit', $dosen->id_dosen) }}">Edit Data</a></div>
</div>
@endsection
