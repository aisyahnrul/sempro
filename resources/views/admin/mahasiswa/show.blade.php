@extends('layouts.app')
@section('title','Detail Mahasiswa')
@section('page-title','Detail Mahasiswa')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
<div class="card" style="max-width:760px;">
    <div class="card-head"><h3>{{ $mahasiswa->nama }}</h3><span class="badge status-info"><span class="dot"></span>Mahasiswa</span></div>
        <div class="kv"><span class="k">NIM</span><span class="v">{{ $mahasiswa->nim }}</span></div>
        <div class="kv"><span class="k">Username</span><span class="v">{{ $mahasiswa->user->username }}</span></div>
    </div>
    <div class="form-actions"><a class="btn btn-outline" href="{{ route('admin.mahasiswa.index') }}">← Kembali</a><a class="btn btn-primary" href="{{ route('admin.mahasiswa.edit', $mahasiswa->id_mhs) }}">Edit Data</a></div>
</div>
@endsection
