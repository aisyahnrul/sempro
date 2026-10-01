@extends('layouts.app')

@section('title', 'Ganti Dosen Pembimbing')
@section('page-title', 'Ganti Dosen Pembimbing')
@section('page-subtitle', 'Sistem Pengajuan Proposal SEMPRO')

@section('content')

<div class="card" style="max-width:760px;">
    <div class="card-head">
        <div>
            <h3>Data Mahasiswa</h3>
            <p style="margin:4px 0 0;">
                Pastikan mahasiswa yang akan diproses sudah benar.
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

    <div class="kv">
        <span class="k">Dosen Saat Ini</span>
        <span class="v">{{ $bimbingan->dosen->nama }}</span>
    </div>
</div>

<div class="card" style="max-width:760px;">
    <div class="card-head">
        <h3>Penggantian Dosen Pembimbing</h3>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0;padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.bimbingan.ganti.store', $mahasiswa->id_mhs) }}"
    >
        @csrf
        @method('PUT')

        <div class="field">
            <label for="id_dosen">
                Dosen Pembimbing Baru <span class="required">*</span>
            </label>

            <div class="searchable-select" id="dosenSelect">

                <input
                    type="text"
                    id="dosenSearch"
                    placeholder="Cari nama atau NIP dosen..."
                    autocomplete="off"
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

                <input
                    type="hidden"
                    name="id_dosen"
                    id="id_dosen"
                    value="{{ old('id_dosen') }}"
                >
            </div>
        </div>

        <div class="field">
            <label for="alasan">
                Alasan Pergantian <span class="required">*</span>
            </label>

            <textarea
                id="alasan"
                name="alasan"
                rows="5"
                maxlength="500"
                placeholder="Jelaskan alasan pergantian dosen pembimbing..."
                required
            >{{ old('alasan') }}</textarea>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">
                Ganti Dosen
            </button>

            <a
                class="btn btn-outline"
                href="{{ route('admin.bimbingan.detail', $mahasiswa->id_mhs) }}"
            >
                Batal
            </a>
        </div>
    </form>
</div>

@if ($riwayat->isNotEmpty())
    <div class="card" style="max-width:760px;">
        <div class="card-head">
            <div>
                <h3>Riwayat Pergantian Dosen</h3>
                <p style="margin:4px 0 0;">
                    Riwayat perubahan dosen pembimbing mahasiswa.
                </p>
            </div>
        </div>

        @foreach ($riwayat as $item)
            <div class="kv">
                <span class="k">
                    {{ $item->changed_at->format('d M Y, H:i') }}
                </span>

                <span class="v">
                    {{ $item->dosenLama->nama ?? '-' }}
                    →
                    {{ $item->dosenBaru->nama ?? '-' }}
                </span>
            </div>

            <div style="padding:8px 0 14px;">
                <span class="muted">Alasan:</span>
                <div>{{ $item->alasan }}</div>
            </div>
        @endforeach
    </div>
@endif

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {

    const dosenSearch = document.getElementById('dosenSearch');
    const dosenOptions = document.getElementById('dosenOptions');
    const dosenHidden = document.getElementById('id_dosen');
    const dosenSelect = document.getElementById('dosenSelect');

    if (!dosenSearch || !dosenOptions || !dosenHidden || !dosenSelect) {
        return;
    }

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
        } else if (emptyMessage) {
            emptyMessage.remove();
        }

        dosenOptions.classList.add('show');
    }

    dosenSearch.addEventListener('focus', filterDosen);
    dosenSearch.addEventListener('input', function () {
        dosenHidden.value = '';
        filterDosen();
    });

    options.forEach(function (option) {
        option.addEventListener('click', function () {
            dosenSearch.value = this.querySelector('b').textContent;
            dosenHidden.value = this.dataset.id;
            dosenOptions.classList.remove('show');
        });
    });

    document.addEventListener('click', function (event) {
        if (!dosenSelect.contains(event.target)) {
            dosenOptions.classList.remove('show');
        }
    });

});
</script>