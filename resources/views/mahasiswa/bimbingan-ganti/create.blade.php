@extends('layouts.app')

@section('title', 'Ganti Dosen Pembimbing')
@section('page-title', 'Ganti Dosen Pembimbing')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')

<div class="card" style="max-width:760px;">
    <div class="card-head">
        <div>
            <h3>Dosen Pembimbing Saat Ini</h3>
            <p style="margin:4px 0 0;">
                Informasi dosen pembimbing yang sedang ditetapkan.
            </p>
        </div>
    </div>

    <div class="kv">
        <span class="k">Nama</span>
        <span class="v">{{ $mahasiswa->nama }}</span>
    </div>

    <div class="kv">
        <span class="k">NIM</span>
        <span class="v">{{ $mahasiswa->nim }}</span>
    </div>

    <div class="kv">
        <span class="k">Dosen Pembimbing</span>
        <span class="v">{{ $bimbingan->dosen->nama }}</span>
    </div>
</div>

@if ($pengajuanAktif)

    <div class="card" style="max-width:760px;">
        <div class="info-banner">
            <p class="small" style="margin:0;">
                Pengajuan pergantian dosen pembimbing Anda sedang diproses oleh Prodi.
            </p>
        </div>
    </div>

@else

    <div class="card" style="max-width:760px;">
        <div class="card-head">
            <div>
                <h3>Ajukan Pergantian Dosen</h3>
                <p style="margin:4px 0 0;">
                    Jelaskan alasan pergantian dosen pembimbing kepada Prodi.
                </p>
            </div>
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
            action="{{ route('mahasiswa.bimbingan-ganti.store') }}"
        >
            @csrf

            <div class="field">
                <label for="alasan">
                    Alasan Pergantian <span class="required">*</span>
                </label>

                <textarea
                    id="alasan"
                    name="alasan"
                    rows="6"
                    maxlength="1000"
                    placeholder="Jelaskan alasan Anda mengajukan pergantian dosen pembimbing..."
                    required
                >{{ old('alasan') }}</textarea>
            </div>

            <div class="info-banner">
                <p class="small" style="margin:0;">
                    Pengajuan akan ditinjau oleh Prodi. Pergantian dosen tidak
                    dilakukan secara otomatis setelah pengajuan dikirim.
                </p>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">
                    Kirim Pengajuan
                </button>

                <a
                    class="btn btn-outline"
                    href="{{ route('mahasiswa.dashboard') }}"
                >
                    Batal
                </a>
            </div>
            @if ($riwayat->isNotEmpty())
                 <div class="card" style="max-width:760px; margin-top:24px;">
                    <div class="card-head">
                        <div>
                            <h3>Riwayat Pengajuan</h3>
                            <p style="margin:4px 0 0;">
                                Riwayat pengajuan pergantian dosen pembimbing Anda.
                            </p>
                        </div>
                    </div>

                    @foreach ($riwayat as $item)
                        <div style="padding:16px 0; border-bottom:1px solid var(--border);">
                            <div style="display:flex; justify-content:space-between; gap:16px; align-items:center;">
                                <b>
                                    {{ $item->created_at->format('d M Y, H:i') }}
                                </b>

                                @if ($item->status === 'Diajukan')
                                    <span class="badge status-warning">
                                        <span class="dot"></span>
                                        Diajukan
                                    </span>
                                @elseif ($item->status === 'Disetujui')
                                    <span class="badge status-success">
                                        <span class="dot"></span>
                                        Disetujui
                                    </span>
                                @else
                                    <span class="badge status-danger">
                                        <span class="dot"></span>
                                        Ditolak
                                    </span>
                                @endif
                            </div>

                            <div class="kv" style="margin-top:12px;">
                                <span class="k">Dosen Saat Ini</span>
                                <span class="v">
                                    {{ $item->dosenSaatIni->nama ?? '-' }}
                                </span>
                            </div>
                        
                            @if ($item->status === 'Disetujui')
                                <div class="kv">
                                    <span class="k">Dosen Baru</span>
                                    <span class="v">
                                        {{ $item->dosenBaru->nama ?? '-' }}
                                    </span>
                                </div>
                            @endif

                            <div class="kv">
                                <span class="k">Alasan Pengajuan</span>
                                <span class="v">
                                    {{ $item->alasan }}
                                </span>
                            </div>

                            @if ($item->catatan_prodi)
                                <div class="info-banner" style="margin-top:12px;">
                                    <p class="small" style="margin:0;">
                                        <b>Catatan Prodi:</b><br>
                                        {{ $item->catatan_prodi }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </form>
    </div>

@endif

@endsection