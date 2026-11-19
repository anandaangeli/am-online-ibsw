@extends('layouts.app')

@section('title', 'Login - AM Online')
@section('body-class', 'login-page')

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <div class="brand-header">
            <div class="brand-icon">
                <i class="bi bi-buildings-fill"></i>
            </div>
            <div class="brand-title">AM ONLINE</div>
            <div class="brand-desc">Sistem Pengajuan Anggaran & Kas Bon</div>
            <span class="badge-hris">
                <i class="bi bi-shield-lock-fill"></i> Portal HRIS IBSW
            </span>
        </div>

        @if (session('success'))
            <div class="alert alert-success custom-alert" role="alert">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info custom-alert" role="alert">
                <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                <div class="flex-grow-1">{{ session('info') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger custom-alert" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                <div class="flex-grow-1">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="formLogin">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" 
                       class="form-control @error('username') is-invalid @enderror" 
                       id="username" 
                       name="username" 
                       value="{{ old('username') }}" 
                       placeholder="NIK atau Email Karyawan" 
                       required 
                       autofocus>
                <label for="username">
                    <i class="bi bi-person me-1"></i> NIK atau Email Karyawan
                </label>
            </div>

            <div class="input-password-wrapper mb-4">
                <div class="form-floating">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Password" 
                           required>
                    <label for="password">
                        <i class="bi bi-key me-1"></i> Password
                    </label>
                </div>
                <button type="button" class="btn-toggle-eye" id="togglePasswordBtn" aria-label="Lihat Password" tabindex="-1">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </button>
            </div>

            <button type="submit" class="btn btn-submit" id="btnSubmit">
                <span class="spinner-border spinner-border-sm d-none" id="btnSpinner" role="status" aria-hidden="true"></span>
                <span id="btnText"><i class="bi bi-box-arrow-in-right me-1"></i> Masuk</span>
            </button>
        </form>

        <div class="mt-4 pt-3 border-top text-center" style="font-size: 0.8rem; color: #64748b;">
            Gunakan akun NIK dan password yang terdaftar di sistem HRIS kantor.
        </div>
    </div>

    <div class="login-footer">
        <p class="mb-0">&copy; {{ date('Y') }} PT Infrastruktur Bisnis Sejahtera</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const passwordInput = document.getElementById('password');
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const eyeIcon = document.getElementById('eyeIcon');
        const formLogin = document.getElementById('formLogin');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnSpinner = document.getElementById('btnSpinner');
        const btnText = document.getElementById('btnText');

        togglePasswordBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });

        formLogin.addEventListener('submit', () => {
            btnSubmit.disabled = true;
            btnSpinner.classList.remove('d-none');
            btnText.innerHTML = 'Memproses...';
        });
    });
</script>
@endsection
