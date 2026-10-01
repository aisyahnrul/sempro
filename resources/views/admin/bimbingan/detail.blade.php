@extends('layouts.app')

@section('title', 'Detail Mahasiswa')
@section('page-title', 'Detail Mahasiswa')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')

<div class="card" style="max-width:760px;">
    <div class="card-head">
        <div>
            <h3>Data Mahasiswa</h3>
            <p style="margin:4px 0 0;">
                Tentukan dosen pembimbing untuk mahasiswa ini.
            </p>
        </div>
    </div>

    <div class="kv">
        <span class="k">Nama</span>
        <span class="v">{{ $mahasiswa->nama }}</span>
    </div>

    <div class="kv">
        <span class="k">NIM</span>
        <span class="v">{{ $mahasiswa->nim }}</span>
    </div>
</div>

<div class="card" style="max-width:760px;">
    <div class="card-head">
        <h3>Dosen Pembimbing</h3>
    </div>

    @if ($mahasiswa->bimbingan->isNotEmpty())

        @php
            $bimbingan = $mahasiswa->bimbingan->first();
        @endphp

        <div class="kv">
            <span class="k">Dosen Pembimbing</span>
            <span class="v">{{ $bimbingan->dosen->nama }}</span>
        </div>

        <div class="info-banner" style="margin-top:14px;">
            <p class="small" style="margin:0;">
                Mahasiswa ini sudah memiliki dosen pembimbing.
            </p>
        </div>
        <div class="form-actions" style="margin-top:14px;">
            <a
                class="btn btn-primary"
                href="{{ route('admin.bimbingan.ganti', $mahasiswa->id_mhs) }}"
            >
                Ganti Dosen Pembimbing
            </a>

            <a
                class="btn btn-outline"
                href="{{ route('admin.bimbingan.index') }}"
            >
                Kembali
            </a>
        </div>

        <div class="form-actions" style="margin-top:14px;">
            <a class="btn btn-outline" href="{{ route('admin.bimbingan.index') }}">
                Kembali
            </a>
        </div>

    @else

        <form method="POST" action="{{ route('admin.bimbingan.store') }}">
            @csrf

            <input type="hidden" name="id_mhs" value="{{ $mahasiswa->id_mhs }}">

            <div class="field">
                <label for="id_dosen">Dosen Pembimbing</label>

                <div class="searchable-select" id="dosenSelect">

    <input
        type="text"
        id="dosenSearch"
        placeholder="Cari nama atau NIP dosen..."
        autocomplete="off"
        required
    >

    <div class="searchable-options" id="dosenOptions">
        @foreach ($dosen as $dsn)
            <button
                type="button"
                class="searchable-option"
                data-id="{{ $dsn->id_dosen }}"
                data-search="{{ strtolower($dsn->nama . ' ' . $dsn->nip) }}"
            >
                <b>{{ $dsn->nama }}</b>
                <span>{{ $dsn->nip }}</span>
            </button>
        @endforeach
    </div>

    <input type="hidden" name="id_dosen" id="id_dosen">

</div>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">
                    Pilih
                </button>

                <a class="btn btn-outline" href="{{ route('admin.bimbingan.index') }}">
                    Batal
                </a>
            </div>
        </form>

    @endif
</div>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {

    const dosenSearch = document.getElementById('dosenSearch');
    const dosenOptions = document.getElementById('dosenOptions');
    const dosenHidden = document.getElementById('id_dosen');
    const dosenSelect = document.getElementById('dosenSelect');

    // Kalau mahasiswa sudah punya dosen pembimbing,
    // elemen searchable dropdown memang tidak ada.
    if (!dosenSearch || !dosenOptions || !dosenHidden || !dosenSelect) {
        return;
    }

    const formDosen = dosenSearch.closest('form');
    const options = document.querySelectorAll('.searchable-option');

    function filterDosen() {
        const keyword = dosenSearch.value.trim().toLowerCase();
        let visible = 0;

        options.forEach(function (option) {
            const searchText = option.dataset.search.toLowerCase();

            if (searchText.includes(keyword)) {
                option.style.display = 'block';
                visible++;
            } else {
                option.style.display = 'none';
            }
        });

        let emptyMessage = document.getElementById('dosenEmpty');

        if (visible === 0) {
            if (!emptyMessage) {
                emptyMessage = document.createElement('div');
                emptyMessage.id = 'dosenEmpty';
                emptyMessage.className = 'searchable-empty';
                emptyMessage.textContent = 'Dosen tidak ditemukan.';
                dosenOptions.appendChild(emptyMessage);
            }
        } else {
            if (emptyMessage) {
                emptyMessage.remove();
            }
        }

        dosenOptions.classList.add('show');
    }

    // Klik input → tampilkan semua dosen
    dosenSearch.addEventListener('focus', function () {
        filterDosen();
    });

    // Ketik → langsung filter
    dosenSearch.addEventListener('input', function () {
        dosenHidden.value = '';
        filterDosen();
    });

    // Klik salah satu dosen
    options.forEach(function (option) {
        option.addEventListener('click', function () {
            dosenSearch.value = this.querySelector('b').textContent;
            dosenHidden.value = this.dataset.id;

            dosenOptions.classList.remove('show');

            dosenSearch.setCustomValidity('');
        });
    });

    // Klik di luar → tutup dropdown
    document.addEventListener('click', function (event) {
        if (!dosenSelect.contains(event.target)) {
            dosenOptions.classList.remove('show');
        }
    });

    // Pastikan user memilih dosen dari daftar
    formDosen.addEventListener('submit', function (event) {
        if (!dosenHidden.value) {
            event.preventDefault();

            dosenSearch.setCustomValidity(
                'Silakan pilih dosen pembimbing dari daftar.'
            );

            dosenSearch.reportValidity();
        }
    });

});
</script>