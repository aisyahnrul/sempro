@extends('layouts.app')

@section('title', 'Dashboard Dosen')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Sistem Pengajuan Proposal Sempro')

@section('content')

<div class="card">
    <div class="card-head">
        <div>
            <h3>Selamat datang di SIPOLAR</h3>

            <p style="margin:4px 0 0;">
                Pantau mahasiswa bimbingan dan tinjau proposal pada setiap tahap proses pengajuan.
            </p>
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
                Ringkasan mahasiswa yang ditugaskan kepada Anda.
            </p>
        </div>

        <a
            href="{{ route('dosen.bimbingan.index') }}"
            class="btn btn-outline btn-sm"
        >
            Lihat Semua
        </a>
    </div>


    @if ($bimbingan->isEmpty())

        <div class="empty-state">
            <h4>Belum ada mahasiswa bimbingan</h4>

            <p>
                Admin/Prodi belum menetapkan mahasiswa kepada Anda.
            </p>
        </div>

    @else

        <div class="table-wrap">

            <table>

                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Judul Proposal</th>
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
                                <b>
                                    {{ $item->mahasiswa->nama }}
                                </b>
                            </td>

                            <td>
                                <span class="muted">
                                    {{ $item->mahasiswa->nim }}
                                </span>
                            </td>

                            <td>
                                {{ $proposal->judul ?? 'Belum mengajukan' }}
                            </td>

                            <td>

                                @if ($proposal)

                                    @include(
                                        'partials.status-badge',
                                        ['status' => $proposal->status]
                                    )

                                @else

                                    <span class="muted">
                                        Belum mengajukan
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