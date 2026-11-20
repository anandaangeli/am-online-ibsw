@extends('layouts.app')

@section('title', 'Login - AM Online IBS')
@section('body-class', 'login-page')

@section('content')
<div class="login-page-wrapper">
    <div class="login-container">
        <div class="login-card">
            {{-- Solid Brand Accent Top Line (No Gradient) --}}
            <div class="login-card-stripe"></div>

            <div class="login-card-body">
                {{-- Brand Header --}}
                <div class="login-brand-header">
                    <div class="login-logo-container">
                        <img src="{{ asset('images/ibsw.png') }}" alt="IBS Logo" class="login-logo-img">
                    </div>

                    <div class="login-brand-title">
                        <span class="login-brand-main">IBS</span>
                        <span class="login-brand-sub">AM Online</span>
                    </div>

                    <p class="login-eyebrow">Dokumen AM & Cash Advance</p>
                    <p class="login-subtitle">
                        Masuk ke portal HRIS IBSW untuk mengelola pengajuan Dokumen AM & kas bon operasional
                    </p>
                </div>

                {{-- Alert Messages --}}
                @if (session('success'))
                    <div class="login-alert-success" role="alert">
                        <i class="bi bi-check-circle-fill login-alert-icon"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="login-alert-error" role="alert">
                        <i class="bi bi-exclamation-triangle-fill login-alert-icon"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Form Login --}}
                <form action="{{ route('login.post') }}" method="POST" id="formLogin">
                    @csrf

                    {{-- Username / NIK / Email --}}
                    <div class="login-form-group">
                        <label class="login-label" for="username">
                            NIK atau Email Karyawan <span class="text-danger">*</span>
                        </label>
                        <div class="login-input-wrapper">
                            <span class="login-input-icon">
                                <i class="bi bi-person"></i>
                            </span>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                class="login-input" 
                                placeholder="Masukkan NIK atau email kantor" 
                                value="{{ old('username') }}" 
                                required 
                                autofocus 
                                autocomplete="username"
                            >
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="login-form-group">
                        <label class="login-label" for="password">
                            Kata Sandi <span class="text-danger">*</span>
                        </label>
                        <div class="login-input-wrapper">
                            <span class="login-input-icon">
                                <i class="bi bi-key"></i>
                            </span>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="login-input" 
                                placeholder="Masukkan kata sandi" 
                                required 
                                autocomplete="current-password"
                            >
                            <button 
                                type="button" 
                                class="login-password-toggle" 
                                id="togglePasswordBtn" 
                                title="Lihat kata sandi" 
                                tabindex="-1"
                            >
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="login-submit-button" id="btnSubmit">
                        <span class="login-spinner d-none" id="btnSpinner"></span>
                        <span id="btnText">
                            <span>Masuk ke Sistem</span>
                            <i class="bi bi-arrow-right ms-1"></i>
                        </span>
                    </button>
                </form>

                {{-- Quick Testing Accounts Section --}}
                <div class="login-demo-section">
                    <button type="button" class="login-demo-toggle" id="demoToggleBtn">
                        <span>Pilih Akun Uji Coba Cepat</span>
                        <span class="login-demo-badge" id="demoToggleBadge">Lihat Akun Demo ▼</span>
                    </button>

                    <div class="login-demo-grid d-none" id="demoGrid">
                        <div class="login-demo-pill" data-user="20160163" data-pass="password">
                            <span class="login-demo-role">Requester (IT Staff)</span>
                            <span class="login-demo-name">Tiopan Indra Wahyudi</span>
                        </div>
                        <div class="login-demo-pill" data-user="test.requester@ibs.test" data-pass="password">
                            <span class="login-demo-role">Requester (SCM)</span>
                            <span class="login-demo-name">Fajar Nugraha</span>
                        </div>
                        <div class="login-demo-pill" data-user="test.asisten@ibs.test" data-pass="password">
                            <span class="login-demo-role">Approver (Asisten Kadiv L1)</span>
                            <span class="login-demo-name">Dwi Handayani, S.T.</span>
                        </div>
                        <div class="login-demo-pill" data-user="test.kadiv@ibs.test" data-pass="password">
                            <span class="login-demo-role">Approver (Kadiv SCM L2)</span>
                            <span class="login-demo-name">Hendro Prasetyo, S.T.</span>
                        </div>
                        <div class="login-demo-pill" data-user="test.accounting@ibs.test" data-pass="password">
                            <span class="login-demo-role">Approver (Accounting L3)</span>
                            <span class="login-demo-name">Bambang Sudarsono, S.E.</span>
                        </div>
                        <div class="login-demo-pill" data-user="admin" data-pass="admin123">
                            <span class="login-demo-role">Approver (Administrator)</span>
                            <span class="login-demo-name">Admin Testing IBS</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="login-footer">
            <p class="login-footer-text">
                &copy; {{ date('Y') }} PT Infrastruktur Bisnis Sejahtera Tbk. All rights reserved.
            </p>
            <div class="login-footer-security">
                <i class="bi bi-shield-check"></i> Enkripsi TLS 1.3 Terverifikasi
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const passwordInput = document.getElementById('password');
        const usernameInput = document.getElementById('username');
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const eyeIcon = document.getElementById('eyeIcon');
        const formLogin = document.getElementById('formLogin');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnSpinner = document.getElementById('btnSpinner');
        const btnText = document.getElementById('btnText');
        const demoToggleBtn = document.getElementById('demoToggleBtn');
        const demoToggleBadge = document.getElementById('demoToggleBadge');
        const demoGrid = document.getElementById('demoGrid');
        const demoPills = document.querySelectorAll('.login-demo-pill');

        // Toggle Password Visibility
        if (togglePasswordBtn && passwordInput && eyeIcon) {
            togglePasswordBtn.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                eyeIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
            });
        }

        // Toggle Demo Accounts
        if (demoToggleBtn && demoGrid && demoToggleBadge) {
            demoToggleBtn.addEventListener('click', () => {
                const isHidden = demoGrid.classList.contains('d-none');
                demoGrid.classList.toggle('d-none', !isHidden);
                demoToggleBadge.textContent = isHidden ? 'Tutup ▲' : 'Lihat Akun Demo ▼';
            });
        }

        // Click on Demo Account Pill
        demoPills.forEach(pill => {
            pill.addEventListener('click', () => {
                demoPills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');

                const user = pill.getAttribute('data-user');
                const pass = pill.getAttribute('data-pass');
                if (usernameInput) usernameInput.value = user;
                if (passwordInput) passwordInput.value = pass;
            });
        });

        // Loading state on submit
        if (formLogin) {
            formLogin.addEventListener('submit', () => {
                if (btnSubmit && btnSpinner && btnText) {
                    btnSubmit.disabled = true;
                    btnSpinner.classList.remove('d-none');
                    btnText.innerHTML = '<span>Memverifikasi Akun...</span>';
                }
            });
        }
    });
</script>
@endsection
