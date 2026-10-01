@extends('layouts.app')
@section('title','Edit Mahasiswa')
@section('page-title','Edit Mahasiswa')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
<div class="card" style="max-width:760px;">
    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id_mhs) }}" method="POST">
        @csrf @method('PUT')
        <div class="grid-2">
            <div class="field"><label for="nama">Nama</label><input type="text" id="nama" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" required></div>
            <div class="field"><label for="nim">NIM</label><input type="text" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required></div>
        </div>
        <div class="info-banner"><p class="small">Password tidak diubah melalui form ini. Jika mahasiswa lupa password,
            Prodi dapat menggunakan tombol <b>Reset Password</b> di bawah.
            Password akan dikembalikan ke default <b>mhs12354</b>.</p></div>
        <div class="form-actions"><button class="btn btn-primary" type="submit">Simpan Perubahan</button><a class="btn btn-outline" href="{{ route('admin.mahasiswa.index') }}">Batal</a></div>
    </form>
        <!-- <div class="form-actions"> -->
        <form action="{{ route('admin.mahasiswa.reset-password', $mahasiswa->id_mhs) }}"
            method="POST"
            style="margin-top:12px;"
            onsubmit="return confirm('Reset password mahasiswa ini menjadi mhs12354');">
            @csrf
            @method('PUT')

            <button type="submit" class="btn btn-outline btn-sm">
                Reset Password
            </button>
        </form>
        <!-- </div> -->
    
</div>
@endsection
