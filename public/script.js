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

    togglePasswordBtn.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });

    function showAlert(type, message) {
        alertBox.className = `alert custom-alert alert-${type}`;
        alertMsg.textContent = message;
        alertIcon.className = type === 'danger' 
            ? 'bi bi-exclamation-triangle-fill fs-5 text-danger' 
            : 'bi bi-check-circle-fill fs-5 text-success';
        alertBox.classList.remove('d-none');
    }

    function hideAlert() {
        alertBox.classList.add('d-none');
    }

    function setLoading(isLoading) {
        btnSubmit.disabled = isLoading;
        btnSpinner.classList.toggle('d-none', !isLoading);
        btnText.innerHTML = isLoading 
            ? 'Memverifikasi...' 
            : '<i class="bi bi-box-arrow-in-right me-1"></i> Masuk';
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        hideAlert();
        userInfoBox.classList.add('d-none');

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();

        setLoading(true);

        try {
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ username, password })
            });

            const data = await res.json();

            if (res.ok && (data.status === true || data.status === 'success')) {
                showAlert('success', 'Verifikasi berhasil');

                const user = data.data || data.user;
                if (user) {
                    userInfoBox.classList.remove('d-none');
                    userDetails.innerHTML = `
                        <div><strong>NIK:</strong> ${user.nik || username}</div>
                        <div><strong>Nama:</strong> ${user.nama || user.name || '-'}</div>
                        <div><strong>Jabatan:</strong> ${user.jabatan || user.position || '-'}</div>
                        <div><strong>Departemen:</strong> ${user.departemen || user.department || '-'}</div>
                    `;
                }
            } else {
                showAlert('danger', data.message || 'NIK atau password salah');
            }
        } catch (err) {
            console.error('Login error:', err);
            showAlert('danger', 'Gagal terhubung ke server');
        } finally {
            setLoading(false);
        }
    });
});
