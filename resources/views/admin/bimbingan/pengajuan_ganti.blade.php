@extends('layouts.app')
@section('title', 'Pengajuan Ganti Dosen')
@section('page-title', 'Pengajuan Ganti Dosen')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')

<div class="card">
    <div class="card-head">
        <div>
            <h3>Pengajuan Pergantian Dosen</h3>
            <p style="margin:4px 0 0;">
                Daftar pengajuan pergantian dosen pembimbing dari mahasiswa.
            </p>
        </div>
    </div>

    @if ($pengajuan->isEmpty())
        <div class="empty-state">
            <h4>Belum ada pengajuan</h4>
            <p>Belum ada mahasiswa yang mengajukan pergantian dosen pembimbing.</p>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Dosen Saat Ini</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pengajuan as $item)
                        <tr>
                            <td>
                                <b>{{ $item->mahasiswa->nama }}</b><br>
                                <span class="muted">
                                    {{ $item->mahasiswa->nim }}
                                </span>
                            </td>

                            <td>
                                {{ $item->dosenSaatIni->nama ?? '-' }}
                            </td>

                            <td style="max-width:300px;">
                                {{ $item->alasan }}
                            </td>

                            <td>
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
                            </td>

                            <td>
                                @if ($item->status === 'Diajukan')
                                    <a
                                        class="btn btn-primary btn-sm"
                                        href="{{ route(
                                            'admin.bimbingan.pengajuan_ganti.proses',
                                            $item->id_pengajuan
                                        ) }}"
                                    >
                                        Proses
                                    </a>
                                @else
                                    <span class="muted">
                                        Sudah diproses
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection