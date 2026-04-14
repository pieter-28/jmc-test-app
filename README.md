# JMC Employee Management System

Aplikasi pengelolaan data pegawai berbasis web yang dibangun sesuai dengan spesifikasi teknis JMC IT Consultant. Aplikasi ini menggunakan **Laravel 12**, **MariaDB**, dan dijalankan di dalam container **Docker**.

## Spesifikasi Teknis (Sesuai Panduan)

Aplikasi ini memenuhi seluruh spesifikasi teknis minimal:
- **Framework**: Laravel 12 (Versi Terbaru)
- **Database**: MariaDB (Latest Version)
- **Web Server**: Nginx (Dockerized) / Support Apache2x environments
- **Bahasa**: PHP 8.2+ 
- **Frontend**: HTML5, CSS3, Javascript, Bootstrap 5.3 (Vanilla CSS components)
- **Containerization**: Full Docker & Docker Compose setup
- **API**: RESTful API dengan Sanctum (GET, POST, PUT, DELETE)

## Fitur Utama

### 1. Modul Autentikasi
- Login dengan Username/Email/Nomor Telepon
- CAPTCHA Image-based untuk mencegah brute force
- Remember Me functionality menggunakan persistent cookies
- Logout otomatis jika status user dinonaktifkan

### 2. Role Based Access Control (RBAC)
Implementasi privilege sesuai panduan:
- **Superadmin**: Akses penuh (Dashboard, Role, User, Logs)
- **Manager HRD**: Dashboard khusus (Chart & Widgets), Read-only Data Pegawai & Transport
- **Admin HRD**: Full CRUD Data Pegawai & Setting Transport, Read-only Dashboard

### 3. Modul Data Pegawai
- **CRUD Operations**: Tambah, Lihat, Ubah, Hapus
- **Smart Filtering**: Filter jabatan (multi), masa kerja (>, =, <), dan pencarian instan
- **Location Support**: Autocomplete Provinsi -> Kabupaten -> Kecamatan
- **Dynamic Form**: Penambahan baris pendidikan secara dinamis
- **Export Functionality**: 
  - **Export Excel**: Seluruh data pegawai ke format .xlsx
  - **Export PDF**: Daftar pegawai rapi ke format .pdf

### 4. Tunjangan Transport & Settings
- Perhitungan otomatis sesuai rumus biaya x jarak x hari kerja
- Validasi jarak minimal 5km dan maksimal 25km
- Validasi syarat minimal 19 hari kerja dalam sebulan
- Pengaturan base fare yang dinamis sesuai kebijakan

### 5. Modul API & Dokumentasi
Mendukung operasi penuh untuk integrasi:
- **Employee API**: CRUD (GET, POST, PUT, DELETE)
- **Location API**: Get Data Wilayah
- **Auth**: Token-based authentication menggunakan Laravel Sanctum

### 6. Log Aktivitas
- Mencatat setiap login dan logout
- Mencatat setiap aksi CRUD (Create, Read, Update, Delete) pada modul terkait
- Informasi detail termasuk IP Address dan User Agent

## Setup & Instalasi

### Prasyarat
- Docker Desktop & Docker Compose
- Koneksi Internet (untuk build awal)

### Langkah Instalasi

1. **Persiapan Environtment**
   ```bash
   cp .env.example .env
   ```

2. **Build & Up Container**
   ```bash
   docker-compose up -d --build
   ```

3. **Inisialisasi Aplikasi**
   ```bash
   # Masuk ke container app
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate:fresh --seed
   docker-compose exec app php artisan storage:link
   ```

4. **Akses Aplikasi**
   - Web App: `http://localhost:8000` (atau port sesuai .env)
   - Adminer: `http://localhost:8080`

### Default Login
- **Username**: `superadmin` / **Password**: `Admin@123`
- **Username**: `manager_hrd` / **Password**: `Manager@123`
- **Username**: `admin_hrd` / **Password**: `Admin@123`

## Dokumentasi Pengujian

Dokumentasi pengujian aplikasi telah disusun secara detail dan dapat diakses pada file:
👉 **[TEST_REPORT_EMPLOYEE_FORM.md](./TEST_REPORT_EMPLOYEE_FORM.md)**

Pengujian mencakup:
- Validasi input form (NIP, Password, Lokasi)
- Pengujian Flow RBAC (Permission check)
- Pengujian Perhitungan Tunjangan
- Pengujian Export Data

## API Endpoint Reference

| Method | Endpoint | Fungsi |
|--------|----------|--------|
| GET | `/api/employees` | List Pegawai |
| POST | `/api/employees` | Tambah Pegawai |
| GET | `/api/employees/{id}` | Detail Pegawai |
| PUT | `/api/employees/{id}` | Update Pegawai |
| DELETE | `/api/employees/{id}` | Hapus Pegawai |

---
**Build by JMC Candidate** - Laravel 12 Enterprise Standard.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
