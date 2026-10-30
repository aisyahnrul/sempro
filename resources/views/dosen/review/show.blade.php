@extends('layouts.app')
@section('title','Review Proposal')
@section('page-title','Review Proposal')
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
</div>

<div class="card">
    <div class="card-head"><h3>Riwayat Proposal</h3><span class="muted">{{ $versiProposal->count() }} versi</span></div>

    @forelse ($versiProposal->sortByDesc('versi') as $versi)
        <div class="version-card">
            <div class="version-head">
                <div>
                    <div class="version-title">Versi {{ $versi->versi }}</div>
                    <div class="muted">Proposal "{{ $proposal->judul }}"</div>
                </div>
                @if ($loop->first)
                    <span class="badge status-purple"><span class="dot"></span>Versi terbaru</span>
                @endif
            </div>

            <div class="file-card">
                <div>
                    <div class="name">Proposal versi {{ $versi->versi }}</div>
                    <div class="muted">Diunggah {{ $versi->uploaded_at->format('d M Y, H:i') }}</div>
                </div>
                <a class="btn btn-outline btn-sm" href="{{ route('dosen.review.file', $versi->id_ver) }}" target="_blank">Lihat Proposal PDF</a>
            </div>

            @if ($versi->reviews->count())
                <div style="margin-top:14px;">
                    <div class="small" style="font-weight:700;color:var(--primary-darker);margin-bottom:7px;">Riwayat Review dan Revisi Pembimbing</div>
                    <p class="muted small" style="margin:0 0 8px;">Riwayat review dari pembimbing sebelumnya tetap ditampilkan sebagai referensi pembimbing saat ini.</p>
                    @foreach ($versi->reviews as $review)
                        <div class="review-note">
                            <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;">
                                <div class="who">
                                    {{ $review->dosen->nama ?? 'Dosen Pembimbing' }}
                                </div>

                                @if ($review->id_dosen == $dosen->id_dosen)
                                    <span class="badge status-success">Pembimbing Saat Ini</span>
                                @else
                                    <span class="badge status-purple">Pembimbing Sebelumnya</span>
                                @endif
                            </div>

                            <div class="text">{{ $review->komentar }}</div>

                            <div class="muted" style="margin-top:6px;">
                                {{ $review->created_at?->format('d M Y, H:i') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="muted" style="margin:12px 0 0;">Belum ada review untuk versi ini.</p>
            @endif
        </div>
    @empty
        <div class="empty-state"><h4>Belum ada versi proposal</h4><p>Belum ada file yang dapat direview.</p></div>
    @endforelse
</div>

@if (in_array($proposal->status, ['Diajukan', 'Ditinjau Ulang']))
    <div class="card">
        <div class="card-head">
            <div>
                <h3>Berikan Review untuk Versi Terbaru</h3>
                <p style="margin:4px 0 0;">Komentar dan keputusan di bawah ini akan disimpan pada versi proposal terbaru.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('dosen.review.store', $proposal->id_prop) }}" method="POST">
            @csrf
            <div class="field">
                <label for="komentar">Komentar / Revisi</label>
                <textarea id="komentar" name="komentar" maxlength="255" placeholder="Tuliskan komentar untuk proposal versi terbaru...">{{ old('komentar') }}</textarea>
                <div class="small" style="margin-top:5px;">Wajib diisi ketika memilih “Minta Revisi”.</div>
            </div>
            <div class="form-actions">
                <button class="btn btn-outline" type="submit" name="action" value="revisi">Minta Revisi</button>
                <button class="btn btn-success" type="submit" name="action" value="setuju">Setujui Proposal</button>
            </div>
        </form>
    </div>
@else
    <div class="info-banner">
        <p><b>Review sudah tidak tersedia untuk status ini.</b></p>
        <p class="small">Riwayat proposal tetap dapat dilihat, tetapi keputusan review baru hanya dilakukan pada status Diajukan atau Ditinjau Ulang.</p>
    </div>
@endif

<div class="form-actions">
    <a class="btn btn-ghost" href="{{ route('dosen.bimbingan.index') }}">← Kembali ke Mahasiswa Bimbingan</a>
</div>
@endsection
