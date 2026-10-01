@extends('layouts.app')
@section('title', 'Proses Pengajuan Ganti Dosen')
@section('page-title', 'Proses Pengajuan Ganti Dosen')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')

<div class="card" style="max-width:760px;">
    <div class="card-head">
        <div>
            <h3>Data Pengajuan</h3>
            <p style="margin:4px 0 0;">
                Tinjau informasi mahasiswa sebelum memproses pengajuan.
            </p>
        </div>
    </div>

    <div class="kv">
        <span class="k">Nama</span>
        <span class="v">{{ $pengajuan->mahasiswa->nama }}</span>
    </div>

    <div class="kv">
        <span class="k">NIM</span>
        <span class="v">{{ $pengajuan->mahasiswa->nim }}</span>
    </div>

    <div class="kv">
        <span class="k">Dosen Saat Ini</span>
        <span class="v">{{ $pengajuan->dosenSaatIni->nama }}</span>
    </div>

    <div class="kv">
        <span class="k">Alasan Pengajuan</span>
        <span class="v">{{ $pengajuan->alasan }}</span>
    </div>
</div>

<div class="card" style="max-width:760px;">
    <div class="card-head">
        <h3>Setujui Pengajuan</h3>
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

    <form
        method="POST"
        action="{{ route(
            'admin.bimbingan.pengajuan_ganti.setujui',
            $pengajuan->id_pengajuan
        ) }}"
    >
        @csrf
        @method('PUT')

        <div class="field">
            <label for="id_dosen_baru">
                Dosen Pembimbing Baru <span class="required">*</span>
            </label>

            <select
                id="id_dosen_baru"
                name="id_dosen_baru"
                required
            >
                <option value="">— Pilih dosen —</option>

                @foreach ($dosen as $dsn)
                    <option
                        value="{{ $dsn->id_dosen }}"
                        {{ old('id_dosen_baru') == $dsn->id_dosen ? 'selected' : '' }}
                    >
                        {{ $dsn->nama }} — {{ $dsn->nip }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="catatan_prodi">
                Catatan Prodi
            </label>

            <textarea
                id="catatan_prodi"
                name="catatan_prodi"
                rows="4"
                maxlength="1000"
                placeholder="Catatan tambahan dari Prodi untuk mahasiswa..."
            >{{ old('catatan_prodi') }}</textarea>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">
                Setujui & Ganti Dosen
            </button>

            <a
                class="btn btn-outline"
                href="{{ route('admin.bimbingan.pengajuan_ganti') }}"
            >
                Batal
            </a>
        </div>
    </form>
</div>

<div class="card" style="max-width:760px;">
    <div class="card-head">
        <h3>Tolak Pengajuan</h3>
    </div>

    <form
        method="POST"
        action="{{ route(
            'admin.bimbingan.pengajuan_ganti.tolak',
            $pengajuan->id_pengajuan
        ) }}"
        onsubmit="return confirm('Tolak pengajuan pergantian dosen ini?');"
    >
        @csrf
        @method('PUT')

        <div class="field">
            <label for="catatan_tolak">
                Alasan Penolakan <span class="required">*</span>
            </label>

            <textarea
                id="catatan_tolak"
                name="catatan_prodi"
                rows="4"
                maxlength="1000"
                placeholder="Jelaskan alasan pengajuan ditolak..."
                required
            ></textarea>
        </div>

        <button class="btn btn-outline" type="submit">
            Tolak Pengajuan
        </button>
    </form>
</div>

@endsection