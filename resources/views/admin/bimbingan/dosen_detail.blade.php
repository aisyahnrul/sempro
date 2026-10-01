@extends('layouts.app')

@section('title', 'Detail Dosen')
@section('page-title', 'Detail Dosen Pembimbing')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')

<div class="card">
    <div class="card-head">
        <div>
            <h3>{{ $dosen->nama }}</h3>
            <p style="margin:4px 0 0;">NIP {{ $dosen->nip }}</p>
        </div>

        <span class="badge status-purple">
            <span class="dot"></span>
            {{ $bimbingan->count() }} mahasiswa
        </span>
    </div>
</div>

<div class="card">
    <div class="card-head">
        <div>
            <h3>Mahasiswa Bimbingan</h3>
            <p style="margin:4px 0 0;">
                Daftar mahasiswa yang ditetapkan kepada dosen ini.
            </p>
        </div>
    </div>

    @if ($bimbingan->isEmpty())

        <div class="empty-state">
            <h4>Belum ada mahasiswa bimbingan</h4>
            <p>Dosen ini belum memiliki mahasiswa bimbingan.</p>
        </div>

    @else

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($bimbingan as $item)

                        @php
                            $proposal = $item->mahasiswa->proposal->first();
                        @endphp

                        <tr>
                            <td>
                                <b>{{ $item->mahasiswa->nama }}</b>
                            </td>

                            <td class="muted">
                                {{ $item->mahasiswa->nim }}
                            </td>

                            <td>
                                @if ($proposal)
                                    @include('partials.status-badge', [
                                        'status' => $proposal->status
                                    ])
                                @else
                                    <span class="muted">Belum mengajukan</span>
                                @endif
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

    <div class="form-actions" style="margin-top:16px;">
        <a
            class="btn btn-outline"
            href="{{ route('admin.bimbingan.index') }}"
        >
            Kembali
        </a>
    </div>
</div>

@endsection