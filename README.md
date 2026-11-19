# AM Online - Form Login HRIS (Laravel & MySQL)

Aplikasi modul autentikasi terintegrasi **Laravel 10** dan database **MySQL** menggunakan arsitektur container berbasis **Docker Compose**.

Dilengkapi juga dengan **phpMyAdmin** untuk mempermudah pengecekan dan manipulasi tabel database MySQL langsung dari web browser.

---

## Arsitektur & Teknologi

* **Backend / Fullstack Framework:** Laravel 10 (PHP 8.2)
* **Database:** MySQL 8.0
* **Database GUI:** phpMyAdmin
* **Frontend UI:** Blade Template + Bootstrap 5.3 + Plus Jakarta Sans + Bootstrap Icons
* **Orkestrasi:** Docker & Docker Compose

---

## Struktur Direktori

```text
tugas form login/
├── docker-compose.yml           # Docker compose utama di root folder
├── am-laravel/                  # Aplikasi Laravel 10 & MySQL Service
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── AuthController.php          # Controller Login, Logout, dan API Auth
│   │   │   ├── DashboardController.php     # Controller Dashboard & KPI Statistik
│   │   │   └── BudgetRequestController.php # Controller CRUD Pengajuan Anggaran
│   │   └── Models/
│   │       ├── User.php                    # Eloquent Model Pengguna
│   │       └── BudgetRequest.php           # Eloquent Model Pengajuan Anggaran
│   ├── database/
│   ├── migrations/
│   │   │   ├── 2026_01_01_000000_create_users_table.php           # Tabel users
│   │   │   └── 2026_01_01_000001_create_budget_requests_table.php # Tabel budget requests
│   │   └── seeders/
│   │       ├── UserSeeder.php              # Seeder akun karyawan demo
│   │       ├── BudgetRequestSeeder.php     # Seeder data pengajuan awal
│   │       └── DatabaseSeeder.php
│   ├── resources/views/
│   │   ├── layouts/app.blade.php           # Layout master Blade
│   │   ├── auth/login.blade.php            # Form login HRIS responsif
│   │   └── dashboard.blade.php             # Dashboard AM Online (KPI, Tabel & Modal)
│   ├── routes/
│   │   ├── web.php                     # Route web autentikasi & dashboard
│   │   └── api.php                     # Endpoint API REST (/api/login, /api/health)
│   ├── public/css/style.css            # Styling visual HRIS AM Online
│   ├── Dockerfile                      # Image container PHP 8.2 + Apache
│   ├── docker-entrypoint.sh            # Auto-install, auto-migrate, & auto-seed
│   └── docker-compose.yml              # Konfigurasi container service
│
├── am-frontend/                 # Template frontend statis (arsip/referensi)
└── am-laravel/                  # Aplikasi utama Laravel 10 & Database
```

---

## Akun Login Demo (Tersimpan di MySQL)

Database diinisialisasi otomatis dengan akun berikut:

| NIK / Username | Password | Nama Karyawan | Role / Jabatan |
|---|---|---|---|
| `20160163` | `password` | TIOPAN INDRA WAHYUDI | Application Development Supervisor |
| `admin` | `admin123` | Administrator IBSW | System Administrator |
| `demo` | `123456` | Demo User HRIS | HR Staff |

> *Catatan: Anda juga dapat login menggunakan alamat Email (misal: `tiopan.wahyudi@ibsmulti.com`).*

---

## Cara Menjalankan Aplikasi

### 1. Buka Docker Desktop
Pastikan aplikasi **Docker Desktop** di Windows Anda sudah dibuka dan statusnya sudah running (*Engine running*).

### 2. Jalankan Docker Compose
Buka Terminal / PowerShell di folder proyek (`D:\tugas form login`), lalu jalankan:

```bash
docker compose up -d --build
```

Container akan otomatis:
1. Mengunduh image PHP 8.2, MySQL 8.0, dan phpMyAdmin.
2. Menginstall dependensi Laravel via Composer.
3. Menjalankan migrasi database (`php artisan migrate`).
4. Mengisi database dengan akun demo (`php artisan db:seed`).

### 3. Akses Melalui Browser

* **Aplikasi Form Login (Laravel):**
  [http://localhost:8000](http://localhost:8000)
* **phpMyAdmin (Manajemen Database MySQL):**
  [http://localhost:8080](http://localhost:8080)
  * **Server:** `mysql`
  * **Username:** `root`
  * **Password:** `rootpassword`
  * **Database:** `am_hris`
* **API Health Check:**
  [http://localhost:8000/api/health](http://localhost:8000/api/health)

---

## Perintah Bermanfaat

* **Melihat log container:**
  ```bash
  docker compose logs -f app
  ```
* **Masuk ke shell container Laravel:**
  ```bash
  docker compose exec app bash
  ```
* **Reset & re-seed database MySQL:**
  ```bash
  docker compose exec app php artisan migrate:fresh --seed
  ```
* **Mematikan container:**
  ```bash
  docker compose down
  ```
* **Mematikan container dan menghapus volume database:**
  ```bash
  docker compose down -v
  ```
