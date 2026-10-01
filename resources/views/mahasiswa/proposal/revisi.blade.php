@extends('layouts.app')
@section('title','Komentar & Revisi')
@section('page-title','Komentar & Revisi')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')
@section('content')
<div class="card">
    <div class="card-head"><div><h3>{{ $proposal->judul }}</h3><p style="margin:4px 0 0;">Riwayat versi proposal dan komentar dosen tersimpan di bawah.</p></div>@include('partials.status-badge',['status'=>$proposal->status])</div>
</div>

<div class="card">
    <div class="card-head"><h3>Riwayat Proposal</h3><span class="muted">{{ $versiProposal->count() }} versi</span></div>

    @forelse ($versiProposal->sortByDesc('versi') as $versi)
        <div class="version-card">
            <div class="version-head">
                <div>
                    <div class="version-title">Versi {{ $versi->versi }}</div>
                    <div class="muted">Diunggah {{ $versi->uploaded_at->format('d M Y, H:i') }}</div>
                </div>
                @if ($loop->first)<span class="badge status-purple"><span class="dot"></span>Terbaru</span>@endif
            </div>

            <div class="file-card">
                <div><div class="name">Proposal "{{ $proposal->judul }}" — Versi {{ $versi->versi }}</div><div class="muted">Berkas proposal</div></div>
                <a class="btn btn-outline btn-sm" href="{{ asset('storage/'.$versi->file_path) }}" target="_blank">Lihat Proposal PDF</a>
            </div>

            @if ($versi->reviews->count())
                <div style="margin-top:14px;">
                    <div class="small" style="font-weight:700;color:var(--primary-darker);margin-bottom:7px;">Catatan Dosen</div>
                    @foreach ($versi->reviews as $review)
                        <div class="review-note">
                            <div class="who">{{ $review->dosen->nama ?? 'Dosen Pembimbing' }}</div>
                            <div class="text">{{ $review->komentar }}</div>
                            <div class="muted" style="margin-top:6px;">{{ $review->created_at?->format('d M Y, H:i') }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="muted" style="margin:12px 0 0;">Belum ada komentar dari dosen untuk versi ini.</p>
            @endif
        </div>
    @empty
        <div class="empty-state"><h4>Belum ada versi proposal</h4><p>Belum ada berkas proposal untuk ditampilkan.</p></div>
    @endforelse
</div>

@if ($proposal->status === 'Revisi')
    <div class="card">
        <div class="card-head"><div><h3>Unggah Hasil Revisi</h3><p style="margin:4px 0 0;">Berkas yang diunggah akan disimpan sebagai versi baru.</p></div></div>
        @if ($errors->any())<div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form action="{{ route('mahasiswa.proposal.uploadRevisi') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="field"><label for="file_proposal">Berkas Revisi (PDF)</label><input type="file" id="file_proposal" name="file_proposal" accept="application/pdf,.pdf" required><div class="small" style="margin-top:6px;">Format PDF, maksimal 10 MB.</div></div>
            <div class="form-actions"><button class="btn btn-primary" type="submit">Unggah Revisi</button></div>
        </form>
    </div>
@elseif ($proposal->status === 'Ditinjau Ulang')
    <div class="info-banner"><p><b>Proposal hasil revisi sudah diunggah.</b></p><p class="small">Proposal sedang ditinjau kembali oleh dosen pembimbing.</p></div>
@elseif ($proposal->status === 'Disetujui' || $proposal->status === 'Terjadwal')
    <div class="info-banner"><p><b>Proposal sudah disetujui.</b></p><p class="small">Riwayat revisi tetap tersedia untuk dilihat.</p></div>
@endif

<div class="form-actions"><a class="btn btn-ghost" href="{{ route('mahasiswa.proposal.index') }}">← Kembali ke Status Pengajuan</a></div>
@endsection
