# Dokumentasi API (API Reference)
**Proyek:** JMC Employee Management System  
**Base URL:** `http://localhost:9000/api`  
**Auth Type:** Laravel Sanctum (Bearer Token)

---

## 🔐 Autentikasi

Semua endpoint kecuali `Location API` memerlukan autentikasi. Gunakan Header:
`Authorization: Bearer {your_token}`

---

## 📍 Location API (Public)
Digunakan untuk fitur cascading dropdown alamat.

### 1. Daftar Kabupaten/Kota
**Endpoint:** `GET /districts/{province_id}`
- **Response:**
  ```json
  [
    { "id": 1, "name": "KOTA ADM. JAKARTA PUSAT" },
    { "id": 2, "name": "KOTA ADM. JAKARTA UTARA" }
  ]
  ```

### 2. Daftar Kecamatan
**Endpoint:** `GET /sub-districts/{district_id}`
- **Response:**
  ```json
  [
    { "id": 101, "name": "GAMBIR" },
    { "id": 102, "name": "SAWAH BESAR" }
  ]
  ```

---

## 👥 Employee API
Endpoint untuk manajemen data pegawai.

### 1. Ambil Semua Pegawai
**Endpoint:** `GET /employees`
- **Query Params:** `page` (optional)
- **Response:** Paginated list of employees.

### 2. Detail Pegawai
**Endpoint:** `GET /employees/{id}`
- **Response:**
  ```json
  {
    "id": 1,
    "nip": "12345678",
    "name": "John Doe",
    "email": "john@jmc.local",
    "position": { "name": "Software Engineer" },
    "department": { "name": "IT" }
  }
  ```

### 3. Tambah Pegawai
**Endpoint:** `POST /employees`
- **Body (JSON):**
  ```json
  {
    "nip": "19900101",
    "name": "Jane Smith",
    "email": "jane@jmc.local",
    "phone": "+62812345678",
    "position_id": 2,
    "department_id": 1
  }
  ```

### 4. Update Pegawai
**Endpoint:** `PUT /employees/{id}`
- **Body (JSON):** Sama seperti POST (dapat parsial).

### 5. Hapus Pegawai
**Endpoint:** `DELETE /employees/{id}`
- **Response:** `204 No Content` atau JSON Success message.

---

## 🛠️ Lainnya (Activity Logs)

### 1. View Logs (Admin Only)
**Endpoint:** `GET /activity-logs`
- **Response:** Daftar aktivitas user dalam format JSON.

---
*Catatan: Dokumentasi ini dibuat secara manual sebagai referensi teknis integrasi.*
