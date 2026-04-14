# Dokumentasi Pengujian Aplikasi (Test Documentation)
**Proyek:** JMC Employee Management System  
**Framework:** Laravel 12  
**Status:** ✅ SEMUA TEST PASSED (SIAP REVIEW)

---

## 1. Modul Autentikasi & Keamanan

| ID | Skenario Pengujian | Langkah | Hasil yang Diharapkan | Status |
|----|--------------------|---------|-----------------------|--------|
| A1 | Login Berhasil | Input username/email + password valid + captcha benar | Masuk ke Dashboard | ✅ |
| A2 | Login Gagal (Password) | Input username valid + password salah | Pesan error "Kredensial tidak cocok" | ✅ |
| A3 | Login Gagal (Captcha) | Input username valid + captcha salah | Pesan error captcha tidak valid | ✅ |
| A4 | Remember Me | Centang 'Remember Me' saat login | Sesi tetap aktif meski browser ditutup | ✅ |
| A5 | Logout | Klik menu logout | Kembali ke halaman login, sesi dihapus | ✅ |
| A6 | Session Protection | Akses /dashboard tanpa login | Redirect otomatis ke halaman login | ✅ |

---

## 2. Role Based Access Control (RBAC)

| Role | Izin Yang Diuji | Hasil Pengujian | Status |
|------|-----------------|-----------------|--------|
| **Superadmin** | Akses Penuh | Dapat mengakses User, Role, Pegawai, dan Log | ✅ |
| **Manager HRD** | Dashboard & View Only | Dapat melihat dashboard grafis, tidak bisa tambah/edit pegawai | ✅ |
| **Admin HRD** | Pegawai & Tunjangan | Dapat CRUD pegawai, tidak bisa akses Kelola Role | ✅ |
| **Bypass** | Direct URL Access | User tanpa izin diarahkan kembali ke dashboard dengan pesan error | ✅ |

---

## 3. Modul Data Pegawai

| ID | Skenario Pengujian | Hasil yang Diharapkan | Status |
|----|--------------------|-----------------------|--------|
| P1 | Create Pegawai | Data tersimpan, NIP unik divalidasi, lokasi cascade bekerja | ✅ |
| P2 | Form Dinamis Pendidikan | Baris pendidikan bisa ditambah/hapus tanpa refresh halaman | ✅ |
| P3 | Search & Filter | Filter masa kerja (>, <, =) dan jabatan mengupdate tabel | ✅ |
| P4 | Export Excel | File .xlsx terunduh dengan data lengkap & mapping relasi | ✅ |
| P5 | Export PDF | File .pdf terunduh/tampil dengan format tabel rapi | ✅ |
| P6 | Paginasi & Sorting | Klik header NIP/Nama mengurutkan data dengan benar | ✅ |

---

## 4. Modul Tunjangan Transport

| ID | Skenario Pengujian | Kriteria | Status |
|----|--------------------|----------|--------|
| T1 | Hitung Tunjangan | Biaya x Jarak (pembulatan) x Hari Kerja | ✅ |
| T2 | Syarat Hari Kerja | Hari < 19 tidak mendapat tunjangan (0) | ✅ |
| T3 | Batasan Jarak | Jarak < 5km atau > 25km ditangani sesuai aturan | ✅ |
| T4 | Employee Type | Hanya pegawai status 'Tetap' yang muncul di list tunjangan | ✅ |

---

## 5. Modul Log Aktivitas

| ID | Skenario Pengujian | Deskripsi Log | Status |
|----|--------------------|---------------|--------|
| L1 | Login/Logout Log | Mencatat aktivitas login dan logout beserta timestamp | ✅ |
| L2 | CRUD Logging | Mencatat aksi "Create user", "Update pegawai", dll | ✅ |
| L3 | Export Logging | Mencatat aksi ekspor data PDF/Excel | ✅ |
| L4 | Metadata Log | Mencatat IP Address dan User Agent pengakses | ✅ |

---

## 6. Pengujian API (REST)

| Endpoint | Method | Hasil yang Diharapkan | Status |
|----------|--------|-----------------------|--------|
| `/api/employees` | GET | Return JSON daftar pegawai (requires Sanctum token) | ✅ |
| `/api/districts/{id}` | GET | Return daftar kabupaten berdasarkan provinsi | ✅ |
| `/api/employees/{id}` | DELETE | Soft delete data pegawai via API | ✅ |

---

## 7. Catatan Teknis Pengujian
- **Versi PHP:** 8.2
- **Database:** MariaDB (InnoDB)
- **Library Ekspor:** Laravel Excel & Barryvdh DomPDF
- **JS Framework:** Vanilla JS (Tanpa dependensi jQuery untuk cascade)

---
*Dokumen ini dibuat sebagai bagian dari pemenuhan syarat teknis pengerjaan aplikasi.*
