# JMC Employee Management System

Aplikasi pengelolaan data pegawai berbasis web dengan Laravel 12, MariaDB, dan Docker.

## Spesifikasi Teknis

- **Framework**: Laravel 12
- **Database**: MariaDB (Latest)
- **Server**: Nginx
- **PHP**: 8.2+
- **Container**: Docker & Docker Compose

## Fitur Utama

### 1. Modul Autentikasi
- Login dengan Username/Email/Nomor Telepon
- CAPTCHA Image-based untuk keamanan
- Remember Me functionality
- Logout dan Session Management
- ActivityLogging untuk setiap login/logout

### 2. Role Based Access Control (RBAC)
- **Superadmin**: Akses penuh ke semua modul
- **Manager HRD**: Akses dashboard, laporan, dan read-only data
- **Admin HRD**: Manajemen data pegawai dan tunjangan

### 3. Kelola Role
Manage privilege dan hak akses untuk setiap role terhadap modul

### 4. Kelola User
- CRUD User dengan password auto-generate
- Status aktif/tidak aktif
- Role assignment
- Validasi username unik
- Instant logout saat statusnya diubah menjadi tidak aktif

### 5. Dashboard
- **Superadmin**: Welcome message
- **Manager HRD**: Widgets total pegawai, chart tipe pegawai, chart gender, tabel 5 pegawai kontrak terbaru
- **Admin HRD**: Welcome message

### 6. Data Pegawai
Kelola data pegawai dengan fitur lengkap:
- Pencarian (nama/NIP/jabatan)
- Filter multi jabatan
- Filter masa kerja (>, =, <)
- Sorting & Pagination
- Bulk select
- Search/Filter yang responsif
- Form dinamis untuk pendidikan (tambah/hapus)
- Autocomplete untuk lokasi (tingkat, kabupaten, kecamatan)
- Otomatis hitung usia
- Detail view lengkap

### 7. Tunjangan Transport
Kelola tunjangan transport dengan perhitungan otomatis:
- Formula: Base Fare × Jarak (dibulatkan) × Hari Kerja
- Pembulatan kilometer: < 0.5 (bawah), >= 0.5 (atas)
- Validasi hari kerja minimum (19 hari)
- Validasi jarak minimal 5 km, maksimal 25 km
- Hanya untuk pegawai tetap
- Otomatis tidak eligible jika hari kerja < 19

### 8. Setting Tunjangan Transport
Kelola parameter tunjangan transport:
- Base fare per kilometer
- Jarak minimum dan maksimum
- Minimum hari kerja
- Effective date untuk setiap perubahan

### 9. Activity Logging
Comprehensive logging sistem:
- Catat login/logout
- Catat semua aksi CRUD
- Record IP address
- Record User Agent
- Timestamp setiap aktivitas

## Setup & Installation

### Prasyarat
- Docker & Docker Compose installed
- Git
- Port 80, 3306, 6379, 8080 available

### Instalasi dengan Docker

1. **Clone/Navigate to Repository**
```bash
cd /path/to/jmc-project
```

2. **Copy Environment File**
```bash
cp .env.example .env
```

3. **Update .env (optional)**
File `.env` sudah dikonfigurasi dengan default values yang sesuai Docker setup.

4. **Build & Run Docker**
```bash
docker-compose up -d
```

5. **Setup Aplikasi**
```bash
# Generate app key
docker-compose exec app php artisan key:generate

# Run migrations dengan seed
docker-compose exec app php artisan migrate --seed

# Create symlink storage
docker-compose exec app php artisan storage:link

# Clear cache
docker-compose exec app php artisan cache:clear
```

6. **Akses Aplikasi**
- **Web Application**: `http://localhost`
- **Adminer (Database)**: `http://localhost:8080`
  - Server: db
  - User: laravel
  - Password: laravel
  - Database: jmc_db

### Default Login Credentials

| Role | Email | Username | Password |
|------|-------|----------|----------|
| Superadmin | superadmin@jmc.local | superadmin | Admin@123 |
| Manager HRD | manager@jmc.local | manager_hrd | Manager@123 |
| Admin HRD | admin@jmc.local | admin_hrd | Admin@123 |

## Struktur Database

### Tabel Sistem
- `users` - Pengguna aplikasi
- `roles` - Role/Peran RBAC
- `permissions` - Permission/Hak akses
- `role_permission` - Mapping role-permission

### Tabel Data Master
- `positions` - Jabatan
- `departments` - Departemen
- `provinces` - Provinsi Indonesia
- `districts` - Kabupaten Indonesia
- `sub_districts` - Kecamatan Indonesia

### Tabel Data Operasional
- `employees` - Data pegawai
- `employee_education` - Riwayat pendidikan
- `transport_allowances` - Tunjangan transport
- `transport_allowance_settings` - Setting tunjangan
- `activity_logs` - Log aktivitas user

## API Documentation

### Endpoint Base
```
/api/
```

### Location API
```
GET /api/districts/{province_id}
GET /api/sub-districts/{district_id}
```

### Employee API
```
GET    /api/employees              - Daftar pegawai (pagination)
POST   /api/employees              - Buat pegawai baru
GET    /api/employees/{id}         - Detail pegawai
PUT    /api/employees/{id}         - Ubah pegawai
DELETE /api/employees/{id}         - Hapus pegawai
```

### User API (Requires: user.view permission)
```
GET /api/users                 - Daftar user
GET /api/users/{id}            - Detail user
```

### Position API
```
GET /api/positions             - Daftar jabatan
GET /api/positions/{id}        - Detail jabatan
```

### Department API
```
GET /api/departments           - Daftar departemen
GET /api/departments/{id}      - Detail departemen
```

## Testing

### Run All Tests
```bash
docker-compose exec app php artisan test
```

### Run Specific Test File
```bash
docker-compose exec app php artisan test tests/Feature/AuthTest.php
```

### Generate Test Coverage
```bash
docker-compose exec app php artisan test --coverage
```

### Database Reset for Testing
```bash
docker-compose exec app php artisan migrate:refresh --seed
```

## Fitur Keamanan

✓ **Password Hashing**: Bcrypt dengan salt  
✓ **CSRF Protection**: Token CSRF pada setiap form  
✓ **CAPTCHA**: Image-based CAPTCHA pada login  
✓ **SQL Injection Prevention**: Query builder & prepared statements  
✓ **XSS Prevention**: Input validation & output escaping  
✓ **Session Security**: HttpOnly dan Secure cookies  
✓ **Activity Logging**: Semua aksi tercatat  
✓ **Permission Validation**: Middleware checking  
✓ **Input Validation**: Server-side validation lengkap  
✓ **Rate Limiting**: File ready untuk implementasi  

## Validasi Data

### User Password
- Minimum 8 karakter
- Minimal 1 huruf besar
- Minimal 1 huruf kecil
- Minimal 1 karakter khusus

### Employee NIP
- Minimum 8 karakter
- Hanya angka
- Unique per employee

### Employee Phone
- Format internasional (+62...)

### Employee Name
- Huruf, angka, spasi, tanda petik saja

### Masa Kerja Filter
- Operator: <, =, >
- Input: Angka tahun

## Troubleshooting

### Database Connection Failed
```bash
docker-compose restart db
docker-compose exec app php artisan migrate
```

### Permission Denied on Storage
```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

### Docker Port Already in Use
Edit `docker-compose.yml` dan ubah port bindings

### Cache Issues
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
```

### Composer Lock Issues
```bash
docker-compose exec app composer update
docker-compose exec app composer dump-autoload
```

## Directory Structure

```
jmc-project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── Api/
│   │   │   └── [DomainController]
│   │   └── Middleware/
│   └── Models/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── docker/
│   └── nginx/
│       └── conf.d/
├── public/
├── resources/
│   ├── views/
│   └── css/
├── routes/
│   ├── web.php
│   ├── api.php
│   └── console.php
├── storage/
├── tests/
├── Dockerfile
├── docker-compose.yml
└── README.md
```

## Deployment Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure SSL certificates
- [ ] Setup backup strategy for database
- [ ] Configure email service
- [ ] Setup monitoring dan alerts
- [ ] Configure proper logging
- [ ] Set appropriate file permissions
- [ ] Enable database backups
- [ ] Configure rate limiting

## Support & References

- [Laravel Documentation](https://laravel.com/docs)
- [MariaDB Documentation](https://mariadb.com/kb/en/)
- [Docker Documentation](https://docs.docker.com/)
- [Nginx Documentation](https://nginx.org/en/docs/)

---
**JMC Employee Management System** - Indonesian Employee Data Management Application built with Laravel 12

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
