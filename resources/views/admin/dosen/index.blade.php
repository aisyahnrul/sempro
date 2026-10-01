@extends('layouts.app')

@section('title', 'Kelola Dosen')
@section('page-title', 'Kelola Dosen')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')
<div class="card">
    <div class="card-head">
        <div>
            <h3>Daftar Dosen</h3>
            <p style="margin:4px 0 0;">Data dosen yang dapat ditugaskan sebagai pembimbing.</p>
        </div>
        <div class="actions">
            <a class="btn btn-outline btn-sm" href="{{ route('admin.mahasiswa.index') }}">Kelola Mahasiswa</a>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.dosen.create') }}">＋ Tambah Dosen</a>
        </div>
    </div>

    @if ($dosen->isEmpty())
        <div class="empty-state">
            <h4>Belum ada data dosen</h4>
            <p>Tambahkan data dosen untuk mulai menentukan pembimbing.</p>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Max Bimbingan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($dosen as $dsn)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dsn->nip }}</td>
                        <td><b>{{ $dsn->nama }}</b></td>
                        <td>{{ $dsn->user->username }}</td>
                        <td><span class="file-tag">{{ $dsn->max_bimbingan }} mahasiswa</span></td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-outline btn-sm" href="{{ route('admin.dosen.show', $dsn->id_dosen) }}">Detail</a>
                                <a class="btn btn-outline btn-sm" href="{{ route('admin.dosen.edit', $dsn->id_dosen) }}">Edit</a>
                                <form action="{{ route('admin.dosen.destroy', $dsn->id_dosen) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Yakin ingin menghapus dosen ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
