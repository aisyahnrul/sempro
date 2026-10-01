@extends('layouts.app')

@section('title', 'Penjadwalan Sempro')
@section('page-title', 'Penjadwalan Sempro')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')
<div class="card">
    <div class="card-head">
        <div>
            <h3>Proposal Siap Dijadwalkan</h3>
            <p style="margin:4px 0 0;">Hanya proposal dengan status <b>Disetujui</b> yang dapat dijadwalkan.</p>
        </div>
        <span class="badge status-success"><span class="dot"></span>{{ $proposal->count() }} proposal</span>
    </div>

    @if ($proposal->isEmpty())
        <div class="empty-state">
            <h4>Belum ada proposal yang siap dijadwalkan</h4>
            <p>Proposal akan muncul setelah dosen memberikan persetujuan.</p>
        </div>
    @else
        <div style="display:flex;flex-direction:column;gap:14px;">
            @foreach ($proposal as $item)
                <div class="version-card">
                    <div class="version-head">
                        <div>
                            <div class="version-title">{{ $item->mahasiswa->nama }}</div>
                            <div class="muted">{{ $item->mahasiswa->nim }} · {{ $item->judul }}</div>
                        </div>
                        @include('partials.status-badge', ['status' => $item->status])
                    </div>

                    @if ($item->jadwal)
                        <div class="info-banner">
                            <p><b>Jadwal sudah tersedia</b></p>
                            <p class="small" style="margin:4px 0 0;">
                                {{ $item->jadwal->tanggal?->format('d F Y') ?? '-' }} ·
                                {{ $item->jadwal->waktu?->format('H:i') ?? '-' }} ·
                                {{ $item->jadwal->ruang }}
                            </p>
                        </div>
                    @else
                        <div class="actions">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.jadwal.create', $item->id_prop) }}">Tetapkan Jadwal</a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
    <div class="card">
        <div class="card-head">
            <div>
                <h3>Riwayat Penjadwalan</h3>
                <p style="margin:4px 0 0;">Daftar proposal yang sudah memiliki jadwal sempro.</p>
            </div>

            <span class="badge status-success">
                <span class="dot"></span>{{ $riwayat->count() }} terjadwal
            </span>
        </div>

        @if ($riwayat->isEmpty())
            <div class="empty-state">
                <h4>Belum ada riwayat penjadwalan</h4>
                <p>Proposal yang sudah dibuatkan jadwal akan muncul di sini.</p>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>NIM</th>
                            <th>Judul Proposal</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Ruang</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($riwayat as $item)
                            <tr>
                                <td>{{ $item->mahasiswa->nama }}</td>
                                <td>{{ $item->mahasiswa->nim }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->jadwal->tanggal?->format('d F Y') ?? '-' }}</td>
                                <td>{{ $item->jadwal->waktu ?? '-' }}</td>
                                <td>{{ $item->jadwal->ruang ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
