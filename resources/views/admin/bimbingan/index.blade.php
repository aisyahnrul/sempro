@extends('layouts.app')

@section('title', 'Dosen Pembimbing')
@section('page-title', 'Penentuan Dosen Pembimbing')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')
<div class="card">
    <div class="card-head">
        <!-- <div style="margin-bottom:16px"> -->
            <div>
            <h3>Beban Bimbingan Dosen</h3>
            <p style="margin:4px 0 0;">Jumlah bimbingan ditampilkan berdasarkan rekomendasi beban bimbingan masing-masing dosen.</p>        </div>
    </div>
    <div class="grid-2 dosen-workload-grid">
    @forelse ($dosen as $dsn)
        @php
            $count = $dsn->bimbingan_count;
            $max = max(1, $dsn->max_bimbingan);
            $percent = min(100, ($count / $max) * 100);
            $class = $count > $max ? 'status-warning' : ($count == $max ? 'status-purple' : 'status-success');        @endphp

       <a href="{{ route('admin.bimbingan.dosen_detail', $dsn->id_dosen) }}" class="dosen-workload-card">
            <div class="dosen-workload-top">
                <div>
                    <h4>{{ $dsn->nama }}</h4>
                    <span class="muted">{{ $dsn->nip }}</span>
                </div>

                @if ($count > $max)
                    <span class="badge status-warning">
                        <span class="dot"></span>
                        Melebihi rekomendasi
                    </span>
                @elseif ($count == $max)
                    <span class="badge status-purple">
                        <span class="dot"></span>
                        Rekomendasi tercapai
                    </span>
                @else
                    <span class="badge status-success">
                        <span class="dot"></span>
                        Sesuai rekomendasi
                    </span>
                @endif
            </div>

            <div class="dosen-workload-number">
                <strong>{{ $count }}</strong>
                <span>mahasiswa bimbingan</span>
            </div>

            <div class="muted">
                Rekomendasi beban: {{ $max }} mahasiswa
            </div>
        </a>
    @empty
        <div class="empty-state">
            <h4>Belum ada data dosen</h4>
            <p>Tambahkan dosen terlebih dahulu melalui menu Kelola Mahasiswa &amp; Dosen.</p>
        </div>
    @endforelse
    </div>
    </dv>
</div>

<div class="card">
    <div class="card-head">
        <div>
            <h3>Tentukan Dosen Pembimbing</h3>
            <p style="margin:4px 0 0;">Setiap mahasiswa pada scope sistem ini memiliki satu dosen pembimbing utama.</p>
        </div>
        <span class="badge status-purple"><span class="dot"></span>Penugasan</span>
    </div>

    <div style="margin-bottom:16px;">
        <div class="search-bar">
        <input
            type="text"
            id="searchMahasiswa"
            placeholder="Cari nama atau NIM mahasiswa..."
            autocomplete="off"
        >
        </div>
</div>
<script>
    const searchInput = document.querySelector('#searchMahasiswa input');

    searchInput.addEventListener('input', function () {
        document.querySelector('#searchMahasiswa').submit();
    });
</script>

@if ($mahasiswa->isEmpty())
    <div class="empty-state">
        <h4>Mahasiswa tidak ditemukan</h4>
        <p>Coba gunakan nama atau NIM yang berbeda.</p>
    </div>
@else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Mahasiswa</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($mahasiswa as $mhs)
                    <tr data-nama="{{ strtolower($mhs->nama) }}" data-nim="{{ strtolower($mhs->nim) }}">
                        <td>
                            <b>{{ $mhs->nama }}</b><br>
                            <span class="muted">{{ $mhs->nim }}</span>
                            @if ($mhs->bimbingan->isNotEmpty())
                            <br>
                            <span class="muted" style="font-size:12px"> Dosen pembimbing sudah ditentukan</span>
                            @endif
                        </td>

                        <td>
                            <a
                                class="btn btn-outline btn-sm"
                                href="{{ route('admin.bimbingan.detail', $mhs->id_mhs) }}"
                            >
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
                <script>
    const searchMahasiswa = document.getElementById('searchMahasiswa');
    const rowsMahasiswa = document.querySelectorAll('tbody tr[data-nama]');

    searchMahasiswa.addEventListener('input', function () {
        const keyword = this.value.trim().toLowerCase();

        rowsMahasiswa.forEach(function (row) {
            const nama = row.dataset.nama;
            const nim = row.dataset.nim;

            const cocok =
                nama.startsWith(keyword) ||
                nim.startsWith(keyword);

            row.style.display = cocok ? '' : 'none';
        });
    });
</script>
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
