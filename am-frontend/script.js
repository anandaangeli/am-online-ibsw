document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formLogin');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    const eyeIcon = document.getElementById('eyeIcon');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnSpinner = document.getElementById('btnSpinner');
    const btnText = document.getElementById('btnText');
    const alertBox = document.getElementById('alertBox');
    const alertMsg = document.getElementById('alertMsg');
    const alertIcon = document.getElementById('alertIcon');
    const userInfoBox = document.getElementById('userInfoBox');
    const userDetails = document.getElementById('userDetails');
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
            hideAlert();
        });
    });

    function showAlert(type, message) {
        alertBox.className = type === 'danger' ? 'login-alert-error' : 'login-alert-success';
        alertMsg.textContent = message;
        alertIcon.className = type === 'danger'
            ? 'bi bi-exclamation-triangle-fill login-alert-icon'
            : 'bi bi-check-circle-fill login-alert-icon';
        alertBox.classList.remove('d-none');
    }

    function hideAlert() {
        alertBox.classList.add('d-none');
    }

    function setLoading(isLoading) {
        btnSubmit.disabled = isLoading;
        btnSpinner.classList.toggle('d-none', !isLoading);
        btnText.innerHTML = isLoading
            ? '<span>Memverifikasi Akun...</span>'
            : '<span>Masuk ke Sistem</span><i class="bi bi-arrow-right ms-1"></i>';
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        hideAlert();
        userInfoBox.classList.add('d-none');

        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();

        if (!username || !password) {
            showAlert('danger', 'Harap lengkapi NIK/Email dan kata sandi.');
            return;
        }

        setLoading(true);

        try {
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ username, password })
            });

            const data = await res.json();

            if (res.ok && (data.status === true || data.status === 'success')) {
                showAlert('success', 'Verifikasi berhasil. Selamat datang!');

                const user = data.data || data.user;
                if (user) {
                    userInfoBox.classList.remove('d-none');
                    userDetails.innerHTML = `
                        <div><strong>NIK / ID:</strong> ${user.nik || username}</div>
                        <div><strong>Nama:</strong> ${user.nama || user.name || '-'}</div>
                        <div><strong>Jabatan:</strong> ${user.jabatan || user.position || '-'}</div>
                        <div><strong>Divisi:</strong> ${user.division || user.departemen || '-'}</div>
                    `;
                }
            } else {
                showAlert('danger', data.message || 'NIK / Email atau Password salah. Periksa kembali data Anda.');
            }
        } catch (err) {
            console.error('Login error:', err);
            showAlert('danger', 'Gagal terhubung ke server backend.');
        } finally {
            setLoading(false);
        }
    });
});
