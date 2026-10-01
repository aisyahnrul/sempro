@extends('layouts.app')

@section('title', 'Jadwalkan Sempro')
@section('page-title', 'Jadwalkan Seminar Proposal')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')
<div class="card">
    <div class="card-head">
        <div>
            <h3>{{ $proposal->judul }}</h3>
            <p style="margin:4px 0 0;">{{ $proposal->mahasiswa->nama }} · {{ $proposal->mahasiswa->nim }}</p>
        </div>
        @include('partials.status-badge', ['status' => $proposal->status])
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0;padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.jadwal.store', $proposal->id_prop) }}" method="POST">
        @csrf

        <div class="grid-3">
            <div class="field">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
            </div>
            <div class="field">
                <label for="waktu">Waktu</label>
                <input type="time" id="waktu" name="waktu" value="{{ old('waktu') }}" required>
            </div>
            <div class="field">
                <label for="ruang">Ruang</label>
                <input type="text" id="ruang" name="ruang" value="{{ old('ruang') }}" maxlength="50" placeholder="Contoh: Ruang Sidang 1" required>
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Simpan Jadwal</button>
            <a class="btn btn-outline" href="{{ route('admin.jadwal.index') }}">Batal</a>
        </div>
    </form>
</div>
@endsection
