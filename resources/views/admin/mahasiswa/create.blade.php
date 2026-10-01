@extends('layouts.app')
@section('title','Tambah Mahasiswa')
@section('page-title','Tambah Mahasiswa')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
<div class="card" style="max-width:760px;">
    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
        @csrf
        <div class="grid-2">
            <div class="field"><label for="nama">Nama</label><input type="text" id="nama" name="nama" value="{{ old('nama') }}" required></div>
            <div class="field"><label for="nim">NIM</label><input type="text" id="nim" name="nim" value="{{ old('nim') }}" required></div>
        </div>
        <div class="grid-2">
            <div class="field">
                <label for="password">Password Awal</label><input type="password" id="password" value="mhs12354" readonly>
                <p class="hint">Password awal otomatis untuk akun mahasiswa.</p>
            </div>
        </div>
        <div class="info-banner"><p class="small">Akun mahasiswa dibuat dan dikelola oleh Prodi.</p></div>
        <div class="form-actions"><button class="btn btn-primary" type="submit">Simpan Mahasiswa</button><a class="btn btn-outline" href="{{ route('admin.mahasiswa.index') }}">Batal</a></div>
    </form>
</div>
@endsection
