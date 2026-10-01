@extends('layouts.app')
@section('title','Tambah Dosen')
@section('page-title','Tambah Dosen')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
<div class="card" style="max-width:760px;">
    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form action="{{ route('admin.dosen.store') }}" method="POST">
        @csrf
        <div class="grid-2">
            <div class="field"><label for="nama">Nama</label><input type="text" id="nama" name="nama" value="{{ old('nama') }}" required></div>
            <div class="field"><label for="nip">NIP</label><input type="text" id="nip" name="nip" value="{{ old('nip') }}" required></div>
        </div>
        <div class="grid-2">
            <div class="field">
                <label for="password">Password Awal</label><input type="password" id="password" value="dosen12354" readonly>
                <p class="hint">Password awal otomatis untuk akun dosen</p>
            </div>
        </div>
        <div class="field"><label for="max_bimbingan">Maksimal Bimbingan</label><input type="number" id="max_bimbingan" name="max_bimbingan" value="{{ old('max_bimbingan', 4) }}" min="1" required></div>
        <div class="form-actions"><button class="btn btn-primary" type="submit">Simpan Dosen</button><a class="btn btn-outline" href="{{ route('admin.dosen.index') }}">Batal</a></div>
    </form>
</div>
@endsection
