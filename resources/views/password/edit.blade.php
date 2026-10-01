@extends('layouts.app')

@section('title', 'Ubah Password')
@section('page-title', 'Ubah Password')
@section('page-subtitle', 'Perbarui kata sandi akun Anda')

@section('content')

<div class="card">

    <div class="card-head">
        <div>
            <h3>Ubah Password</h3>
            <p class="muted">
                Gunakan password baru yang mudah diingat tetapi tidak mudah ditebak.
            </p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">

        @csrf
        @method('PUT')

        <div class="field">
            <label for="current_password">
                Password Saat Ini
            </label>

            <input
                type="password"
                id="current_password"
                name="current_password"
                required
            >
        </div>

        <div class="field">
            <label for="password">
                Password Baru
            </label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >

            <div class="small">
                Minimal 8 karakter.
            </div>
        </div>

        <div class="field">
            <label for="password_confirmation">
                Konfirmasi Password Baru
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
            >
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Simpan Password
            </button>
        </div>

    </form>

</div>

@endsection