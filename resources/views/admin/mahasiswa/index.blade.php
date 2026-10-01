@extends('layouts.app')

@section('title', 'Kelola Mahasiswa & Dosen')
@section('page-title', 'Kelola Mahasiswa & Dosen')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')
<div class="card">
    <div class="card-head">
        <div>
            <h3>Daftar Mahasiswa</h3>
            <p style="margin:4px 0 0;">Data mahasiswa yang terdaftar pada sistem.</p>
        </div>
        <div class="actions">
            <a class="btn btn-outline btn-sm" href="{{ route('admin.dosen.index') }}">Kelola Dosen</a>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.mahasiswa.create') }}">＋ Tambah Mahasiswa</a>
        </div>
    </div>

    @if ($mahasiswa->isEmpty())
        <div class="empty-state">
            <h4>Belum ada data mahasiswa</h4>
            <p>Tambahkan data mahasiswa untuk mulai menggunakan sistem.</p>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($mahasiswa as $mhs)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mhs->nim }}</td>
                        <td><b>{{ $mhs->nama }}</b></td>
                        <td>{{ $mhs->user->username }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-outline btn-sm" href="{{ route('admin.mahasiswa.show', $mhs->id_mhs) }}">Detail</a>
                                <a class="btn btn-outline btn-sm" href="{{ route('admin.mahasiswa.edit', $mhs->id_mhs) }}">Edit</a>
                                <form action="{{ route('admin.mahasiswa.destroy', $mhs->id_mhs) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Yakin ingin menghapus mahasiswa ini?')">Hapus</button>
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
