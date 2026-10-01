<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk · SIPOLAR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sempro.css') }}">
</head>
<body>
<div class="login-wrap">
    <div class="login-card">
        <div class="login-brand">
            <div class="mark"><img src="{{ asset('images/sempro-logo.png') }}" alt="Logo SEMPRO"></div>
            <span>SISTEM PENGAJUAN PROPOSAL SEMINAR</span>
        </div>

        <h1 align="center">Selamat datang di SIPOLAR</h1>
        <p align="center">Silakan masuk untuk melanjutkan pengajuan dan memantau proses seminar proposal Anda.</p>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0;padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.proses') }}" method="POST">
            @csrf
            <div class="field">
                <label for="username">NIM/NIP/Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" autocomplete="username" required autofocus placeholder="Masukkan NIM, NIP atau Username">
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" autocomplete="current-password" required placeholder="Masukkan Password">
            </div>

            <button class="btn btn-primary btn-block" type="submit">Masuk ke Sistem</button>
        </form>

        <div class="login-help" align="center">
            <b>Butuh bantuan masuk?</b><br>
            Hubungi Admin/Prodi melalui kontak resmi yang ditetapkan oleh Prodi.
            WhatsApp:<b><a href="https://wa.me/6288980784232" target="_blank" rel="noopener"> 088980784232 </a></b>
        </div>
    </div>
</div>
</body>
</html>
