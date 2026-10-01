@extends('layouts.app')
@section('title','Edit Dosen')
@section('page-title','Edit Dosen')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
<div class="card" style="max-width:760px;">
    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form action="{{ route('admin.dosen.update', $dosen->id_dosen) }}" method="POST">
        @csrf @method('PUT')
        <div class="grid-2">
            <div class="field"><label for="nama">Nama</label><input type="text" id="nama" name="nama" value="{{ old('nama', $dosen->nama) }}" required></div>
            <div class="field"><label for="nip">NIP</label><input type="text" id="nip" name="nip" value="{{ old('nip', $dosen->nip) }}" required></div>
        </div>
        <div class="field"><label for="max_bimbingan">Maksimal Bimbingan</label><input type="number" id="max_bimbingan" name="max_bimbingan" value="{{ old('max_bimbingan', $dosen->max_bimbingan) }}" min="1" required></div>
                <div class="info-banner"><p class="small">Password tidak diubah melalui form ini. Jika dosen lupa password,
            Prodi dapat menggunakan tombol <b>Reset Password</b> di bawah.
            Password akan dikembalikan ke default <b>dosen12354</b>.</p></div>
        <div class="form-actions"><button class="btn btn-primary" type="submit">Simpan Perubahan</button><a class="btn btn-outline" href="{{ route('admin.dosen.index') }}">Batal</a></div>
    </form>
        <form action="{{ route('admin.dosen.reset-password', $dosen->id_dosen) }}"
        method="POST"
        style="margin-top:12px;"
        onsubmit="return confirm('Reset password dosen ini menjadi dosen12354?');">
        @csrf
        @method('PUT')

        <button type="submit" class="btn btn-outline btn-sm">
            Reset Password
        </button>
        </form>
</div>
@endsection
