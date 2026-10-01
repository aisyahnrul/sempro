@extends('layouts.app')
@section('title','Status Pengajuan')
@section('page-title','Status Pengajuan Saya')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
@if (!$proposal)
    <div class="card empty-state">
        <h3>Belum ada pengajuan proposal</h3>
        <p>Ajukan proposal terlebih dahulu untuk memulai proses sempro.</p>
        <div class="form-actions" style="justify-content:center;"><a class="btn btn-primary" href="{{ route('mahasiswa.proposal.create') }}">Ajukan Proposal</a></div>
    </div>
@else
    @php
        $displayStatus = $proposal->status === 'Menunggu Jadwal'
            ? 'Terjadwal'
            : $proposal->status;

        $steps = ['Diajukan', 'Ditinjau', 'Revisi', 'Ditinjau Ulang', 'Disetujui', 'Terjadwal'];

        $statusIndex = array_search($displayStatus, $steps, true);
        $statusIndex = $statusIndex === false ? 0 : $statusIndex;

        $versiTerbaru = $proposal->proposalVer->sortByDesc('versi')->first();
    @endphp

    <div class="card">
        <div class="card-head">
            <div><h3>{{ $proposal->judul }}</h3><p style="margin:4px 0 0;">{{ $proposal->mahasiswa->nim }}</p></div>
            @include('partials.status-badge', ['status' => $displayStatus])
        </div>

        <div class="stepper">
            @foreach ($steps as $index => $step)
                <div class="step {{ $index < $statusIndex ? 'completed' : ($index === $statusIndex ? 'current' : '') }}">
                    @if ($index > 0)<div class="line"></div>@endif
                    <div class="circle">{{ $index + 1 }}</div>
                    <div class="lbl">{{ $step }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-head"><h3>Informasi Pengajuan</h3></div>
            <div class="kv-grid">
                <div class="kv"><span class="k">Versi proposal</span><span class="v">{{ $proposal->proposalVer->count() }} versi</span></div>
                <div class="kv"><span class="k">Versi terbaru</span><span class="v">{{ $versiTerbaru->versi ?? '-' }}</span></div>
                <div class="kv"><span class="k">Status</span><span class="v">{{ $displayStatus }}</span></div>
                <div class="kv"><span class="k">Dosen pembimbing</span><span class="v">{{ optional($proposal->mahasiswa->bimbingan->first()?->dosen)->nama ?? 'Belum ditentukan' }}</span></div>
            </div>
        </div>

        <div class="card">
            <div class="card-head"><h3>Catatan Terbaru</h3></div>
            @if ($versiTerbaru && $versiTerbaru->reviews->count())
                @foreach ($versiTerbaru->reviews as $review)
                    <div class="review-note">
                        <div class="who">{{ $review->dosen->nama ?? 'Dosen Pembimbing' }}</div>
                        <div class="text">{{ $review->komentar }}</div>
                    </div>
                @endforeach
            @else
                <div class="empty-state" style="padding:24px 10px;"><p>Belum ada komentar pada versi terbaru.</p></div>
            @endif
        </div>
    </div>

    @if ($proposal->status === 'Revisi')
        <div class="info-banner">
            <p><b>Proposal perlu direvisi.</b></p>
            <p class="small">Buka halaman Komentar &amp; Revisi untuk melihat catatan dosen dan mengunggah versi berikutnya.</p>
            <div class="form-actions"><a class="btn btn-primary btn-sm" href="{{ route('mahasiswa.proposal.revisi') }}">Buka Komentar &amp; Revisi</a></div>
        </div>
    @endif
@endif
@endsection
