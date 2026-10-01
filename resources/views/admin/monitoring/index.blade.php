@extends('layouts.app')

@section('title', 'Monitoring Pengajuan')
@section('page-title', 'Monitoring Pengajuan')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')
<div class="card">
    <div class="card-head">
        <div>
            <h3>Daftar Pengajuan</h3>
            <p style="margin:4px 0 0;">Status proposal dan versi terakhir.</p>
        </div>
        <span class="badge status-purple"><span class="dot"></span>{{ $proposal->count() }} pengajuan</span>
    </div>

    @if ($proposal->isEmpty())
        <div class="empty-state">
            <h4>Belum ada pengajuan proposal</h4>
            <p>Data akan muncul setelah mahasiswa mengirimkan proposal.</p>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mahasiswa</th>
                        <th>Judul Proposal</th>
                        <th>Dosen Pembimbing</th>
                        <th>Versi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($proposal as $item)
                    @php
                        $bimbingan = $item->mahasiswa->bimbingan->first();
                        $versiTerbaru = $item->proposalVer->sortByDesc('versi')->first();
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <b>{{ $item->mahasiswa->nama }}</b><br>
                            <span class="muted">{{ $item->mahasiswa->nim }}</span>
                        </td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $bimbingan->dosen->nama ?? 'Belum ditentukan' }}</td>
                        <td>{{ $versiTerbaru->versi ?? '-' }}</td>
                        <td>@include('partials.status-badge', ['status' => $item->status])</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
