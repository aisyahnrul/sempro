<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIPOLAR')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/sempro.css') }}">
</head>
<body>
@php
    $user = auth()->user();
    $role = $user->role;

    if ($role === 'mahasiswa') {
        $displayName = optional($user->mahasiswa)->nama ?? $user->username;
        $roleLabel = 'Mahasiswa';
        $homeRoute = route('mahasiswa.dashboard');
    } elseif ($role === 'dosen') {
        $displayName = optional($user->dosen)->nama ?? $user->username;
        $roleLabel = 'Dosen Pembimbing';
        $homeRoute = route('dosen.dashboard');
    } else {
        $displayName = 'Prodi';
        $roleLabel = 'Pengelola Sistem';
        $homeRoute = route('admin.dashboard');
    }

    $initial = strtoupper(mb_substr($displayName, 0, 1));
@endphp

<div class="app-shell">
    <aside class="sidebar">
        <a href="{{ $homeRoute }}" class="sidebar-brand">
            <div class="mark">
                <img src="{{ asset('images/sempro-logo.png') }}" alt="Logo SEMPRO">
            </div>
            <span>SIPOLAR</span>
        </a>

        <div class="role-chip">
            <b>{{ $displayName }}</b>
            {{ $roleLabel }}
        </div>

        <ul class="nav-list">
            @if ($role === 'admin')
                <li>
                    <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <span class="nav-symbol">⌂</span>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('admin.monitoring.*') ? 'active' : '' }}" href="{{ route('admin.monitoring.index') }}">
                        <span class="nav-symbol">◫</span>
                        Monitoring Pengajuan
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs(    'admin.bimbingan.index','admin.bimbingan.detail','admin.bimbingan.dosen_detail','admin.bimbingan.ganti','admin.bimbingan.ganti.store') ? 'active' : '' }}" href="{{ route('admin.bimbingan.index') }}">
                        <span class="nav-symbol">◌</span>
                        Dosen Pembimbing
                    </a>
                </li>
                <li>
                    
                    <a class="nav-item {{ request()->routeIs('admin.bimbingan.pengajuan_ganti') ? 'active' : '' }}"href="{{ route('admin.bimbingan.pengajuan_ganti') }}">
                        <span class="nav-symbol">↻</span>
                        Pengajuan Ganti Dosen
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('admin.mahasiswa.*', 'admin.dosen.*') ? 'active' : '' }}" href="{{ route('admin.mahasiswa.index') }}">
                        <span class="nav-symbol">▣</span>
                        Kelola Mahasiswa &amp; Dosen
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}" href="{{ route('admin.jadwal.index') }}">
                        <span class="nav-symbol">◷</span>
                        Penjadwalan Sempro
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('password.*') ? 'active' : '' }}"
                    href="{{ route('password.edit') }}">
                        <span class="nav-symbol">⌘</span>
                        Ubah Password
                    </a>
                </li>
            @elseif ($role === 'dosen')
                <li>
                    <a class="nav-item {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}" href="{{ route('dosen.dashboard') }}">
                        <span class="nav-symbol">⌂</span>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('dosen.bimbingan.*', 'dosen.review.*') ? 'active' : '' }}" href="{{ route('dosen.bimbingan.index') }}">
                        <span class="nav-symbol">♙</span>
                        Mahasiswa Bimbingan
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('password.*') ? 'active' : '' }}"
                    href="{{ route('password.edit') }}">
                        <span class="nav-symbol">⌘</span>
                        Ubah Password
                    </a>
                </li>
            @else
                <li>
                    <a class="nav-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}" href="{{ route('mahasiswa.dashboard') }}">
                        <span class="nav-symbol">⌂</span>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('mahasiswa.proposal.index') ? 'active' : '' }}" href="{{ route('mahasiswa.proposal.index') }}">
                        <span class="nav-symbol">◉</span>
                        Status Pengajuan
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('mahasiswa.proposal.create') ? 'active' : '' }}" href="{{ route('mahasiswa.proposal.create') }}">
                        <span class="nav-symbol">＋</span>
                        Ajukan Proposal
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('mahasiswa.proposal.revisi') ? 'active' : '' }}" href="{{ route('mahasiswa.proposal.revisi') }}">
                        <span class="nav-symbol">↻</span>
                        Komentar &amp; Revisi
                    </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('mahasiswa.jadwal.*') ? 'active' : '' }}" href="{{ route('mahasiswa.jadwal.index') }}">
                        <span class="nav-symbol">◷</span>
                        Jadwal Sempro
                    </a>
                </li>
                <li>
                        <a class="nav-item {{ request()->routeIs('mahasiswa.bimbingan-ganti.*') ? 'active' : '' }}"
                            href="{{ route('mahasiswa.bimbingan-ganti.create') }}">
                            <span class="nav-symbol">⁜</span>
                            Ganti Dosen Pembimbing
                        </a>
                </li>
                <li>
                    <a class="nav-item {{ request()->routeIs('password.*') ? 'active' : '' }}"
                    href="{{ route('password.edit') }}">
                        <span class="nav-symbol">⌘</span>
                        Ubah Password
                    </a>
                </li>
            @endif
        </ul>

        <div class="sidebar-foot">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <span class="nav-symbol">↪</span>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <div>
                <h2>@yield('page-title', 'SEMPRO')</h2>
                <div class="sub">@yield('page-subtitle')</div>
            </div>

            <!-- <div class="user-chip">
                <div class="avatar">{{ $initial }}</div>
                <div class="who">
                    <b>{{ $displayName }}</b>
                    {{ $roleLabel }}
                </div>
            </div> -->
        </div>

        <main class="content">
            <div class="view">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[required], select[required], textarea[required]').forEach(function (field) {
        if (field.type === 'hidden') {
            return;
        }

        const fieldId = field.id;

        if (!fieldId) {
            return;
        }

        const label = document.querySelector(`label[for="${fieldId}"]`);

        if (!label || label.querySelector('.required')) {
            return;
        }

        const star = document.createElement('span');
        star.className = 'required';
        star.textContent = ' *';

        label.appendChild(star);
    });
});
</script>
</body>
<script>
document.querySelectorAll('input[type="password"]').forEach(function(input) {
    const wrapper = document.createElement('div');
    wrapper.className = 'password-field';

    input.parentNode.insertBefore(wrapper, input);
    wrapper.appendChild(input);

    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'password-toggle';
    button.setAttribute('aria-label', 'Tampilkan password');

    button.innerHTML = `
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.8"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/>
            <circle cx="12" cy="12" r="2.5"/>
        </svg>
    `;

    button.addEventListener('click', function() {
        const isPassword = input.type === 'password';

        input.type = isPassword ? 'text' : 'password';
        button.setAttribute(
            'aria-label',
            isPassword ? 'Sembunyikan password' : 'Tampilkan password'
        );
    });

    wrapper.appendChild(button);
});
</script>
</html>
