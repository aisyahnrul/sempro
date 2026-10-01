@extends('layouts.app')

@section('title', 'Mahasiswa Bimbingan')
@section('page-title', 'Mahasiswa Bimbingan')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')

<div class="card">

    <div class="card-head">

        <div>

            <h3>Daftar Mahasiswa</h3>

            <p style="margin:4px 0 0;">
                Pilih mahasiswa yang sudah mengajukan proposal untuk melakukan review.
            </p>

        </div>

        <span class="badge status-purple">
            <span class="dot"></span>
            {{ $bimbingan->count() }} mahasiswa
        </span>

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
                        <th>Aksi</th>
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

                                    <a
                                        href="{{ route('dosen.review.show', $proposal->id_prop) }}"
                                        class="btn btn-primary btn-sm"
                                    >
                                        Review Proposal
                                    </a>

                                @else

                                    <span class="muted">
                                        Menunggu pengajuan
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