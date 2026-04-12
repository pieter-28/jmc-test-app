## Spesifikasi Teknis Minimal Harus Dipenuhi

1. PHP versi terbaru
2. MariaDB versi terbaru
3. Apache2x
4. Framework Yii2 2.04x / Laravel 12 / CI 4
5. HTML5, CSS3, Javascript
6. Framework frontend tidak diperbolehkan menggunakan tailwind, diperbolehkan
   menggunakan component based framework seperti bootstrap/material/foundation.
7. Dijalankan di container Docker

## Requirement/Batasan Teknis Khusus

1. Di local peserta (laptop) harus terinstall minimal 2 versi PHP, yaitu versi 7.x dan 8.x, namun
   script yang akan dibuat untuk pengerjaan tes adalah versi PHP yang sesuai dengan
   spesifikasi teknis minimal.
2. Pembuatan tabel database harus menggunakan fasilitas migrasi dari framework, tidak
   diperbolehkan membuat tabel secara langsung di database menggunakan web app
   maupun desktop app seperti adminer, phpmyAdmin, HeidiSQL, Workbench, dan sejenisnya
3. Harus ada operasi data yang menggunakan API, yang mencakup penggunaan untuk get,
   post, put, delete.
4. Kemampuan untuk membuat script testing akan mendapatkan pertimbangan khusus
5. Silahkan membuat asumsi apabila ada hal harus dipenuhi namun informasinya belum ada
   di soal. Peserta uji bisa juga menambahkan metadata yang dibutuhkan.

## Material Penilaian (Urut Prioritas)

1. Kesesuaian dengan ketentuan, tata cara, spesifikasi teknis minimal, requirement teknis
   khusus serta kesesuaian dengan hasil yang diminta dalam soal
2. Tingkat bug (semakin sedikit semakin baik)
3. Tingkat keamanan (semakin sedikit celah keamanan semakin baik)
4. Presentasi hasil pengerjaan tes dan kesesuaian dengan perubahan yang diminta pada
   saat presentasi/review hasil pengerjaan tes
5. Kualitas database (relationship, metadata, kemampuan penggunaan function/procedure)
6. Code Readability
7. UI/UX (tata letak/layout, penggunaan warna, font, kemudahaan penggunaan aplikasi)
8. Lainnya

## Soal / Perintah

1. Buatkan sebuah aplikasi sederhana pengelolaan data pegawai berbasis web dengan
   informasi kebutuhan sebagai berikut:

Keterangan :

- C (Create) = Bisa membuat data baru
- R (Read) = Bisa membaca data
- RO (Read Only) = Hanya bisa membaca data yang dia buat atau hanyadiperuntukkan dirinya.
- U (Update) = Bisa memperbarui/mengubah data
- UO (Update only) = Bisa memperbarui/mengubah data terbatas pada data yang diabuat
- D (Delete) = Bisa menghapus data
- DO (Delete Only) = Bisa menghapus data terbatas pada data yang dia buat
- X = Tidak dapat mengakses modul tersebut
- Y = Bisa mengakses modul tersebut tanpa perlu aksi CRUD

### Module Activity

    - Login/Logout
    - Kelola Role
    - Dashboard
    - Modul Data Pegawai
    - Modul Tunjangan Transport
    - Setting Tunjangan Transport
    - Modul Log

A. Table Role (Table RBAC) ### Role - Superadmin - Login/Logout - Kelola Role - Kelola User (CRUD kecuali hapus data dirinya) - Dashboard (R, Sesuai Role ) - Modul Data Pegawai (X) - Modul Tunjangan Transport (X) - Setting Tunjangan Transport (X) - Modul Log (R)

    - Manager HRD
      - Login/Logout (Y)
      - Kelola Role (X)
      - Kelola User (RO, UO)
      - Dashboard (R, Sesuai Role )
      - Modul Data Pegawai (R)
      - Modul Tunjangan Transport (RO)
      - Setting Tunjangan Transport (X)
      - Modul Log (X)

    - Admin HRD
      - Login/Logout (Y)
      - Kelola Role (X)
      - Kelola User (RO, UO)
      - Dashboard (R, Sesuai Role )
      - Modul Data Pegawai (CRUD, kecuali hapus data pegawai superadmin)
      - Modul Tunjangan Transport (RO)
      - Setting Tunjangan Transport (CRUD)
      - Modul Log (X)

### Penjelanasan

1. login

Login adalah sebuah gerbang keamanan (autentikasi) pada aplikasi atau situs web
yang berfungsi untuk memverifikasi identitas pengguna sebelum mereka diberikan
akses ke fitur atau data tertentu.
Pengguna dapat login dengan memasukkan username atau email atau cellphone
(no.hp) dan password dan captcha yang benar.

- Username/Email/Cell.Phone (Input password dengan aturan tertentu
  (sesuai dengan aturan pembuatan user
  baru pada field password))
- Captcha (Input field, harus sama dengan kode
  captcha yang ditampilkan)
- Remember me (Checkbox untuk mengingat sesi login.
  Apabila pengguna login dengan
  mengaktifkan “remember me”, maka
  pengguna tidak akan ter logout secara
  otomatis (untuk logout dia harus mengklik
  link/tombol logout secara manual));

2. Kelola Role

Modul kelola role digunakan untuk mengatur privilege atau hak akses role terhadap
modul atau dikenal dengan istilah RBAC (Role Based Access Control).

3. Kelola user

Modul untuk melihat, menambahkan, memperbarui, menghapus, memberikan status
aktif atau non aktif pada user.

- Nama Pengguna
  Autosuggestion dan autocomplete.
  Pengguna harus memasukkan minimal
  dua digit untuk memunculkan
  autosuggest, begitu autosuggest muncul,
  maka pengguna tinggal klik nama yang
  dimaksud.
  Tidak boleh memasukkan nama yang
  tidak ada dalam daftar autosuggest
  Data diambil dari data pegawai.

- Username
  Input text, minimal 6 karakter, tidak boleh
  ada spasi, hanya boleh terdiri dari huruf
  serta angka, untuk huruf semuanya harus
  kecil.
  Username bersifat unik, tidak boleh ada
  dua atau lebih username yang identik
  Validasi aturan dilakukan secara onkeyup

- Password
  Digenerate secara otomatis oleh aplikasi
  ketika pembuatan user baru. Setelahnya
  user terkait bisa memperbarui password
  secara mandiri melalui halaman profilnya.
  Aturan password:
  ● Minimal 8 karakter
  ● Tidak boleh ada spasi
  ● Harus ada minimal 1 huruf besar
  ● Harus ada minimal 1 huruf kecil
  ● Harus ada minimal 1 karakter khusus
  Validasi aturan dilakukan onkeyup

- Ketik ulang password
  Pengguna harus mengetikkan ulang
  password sebagai bentuk verifikasi
  Validasi aturan dilakukan onkeyup

- Role
  Dropdown berupa pilihan role. Contoh:
  admin, manajer HRD, staf HRD.

- status
  Checkbox dengan label “Aktif”. Secara
  default tercentang.
  Pengguna yang statusnya aktif dapat
  login. Pengguna yang statusnya nonaktif
  (checkbox tidak tercentang) tidak dapat
  login.
  Apabila user terkait sedang dalam
  kondisi login dan diubah statusnya
  menjadi nonaktif (checkbox dalam
  kondisi unchecked) maka user terkait
  akan terlogout secara otomatis dari
  aplikasi.

4. Dashboard

Dashboard adalah halaman yang pertama kali terbuka ketika pengguna berhasil login
ke aplikasi. Masing-masing role memiliki dashboard sendiri-sendiri.
a. Role Superadmin
Dashboard hanya berisi kalimat “Selamat Datang [Nama Pengguna] - [Role]”
b. Role Manager HRD
Role berisi widget yang menggambarkan informasi berikut

1. Widget
   ● Widget 1: Total Pegawai
   ● Widget 2: Total Pegawai Kontrak
   ● Widget 3: Total Pegawai Tetap
   ● Widget 4: Total Peserta Magang
2. Doughnut Chart Pegawai Kontrak vs Pegawai Tetap vs Magang
3. Doughnut Chart Pegawai Pria vs Wanita
4. Data tabular 5 Pegawai dengan tanggal masuk paling baru, dan jenisnya
   kontrak (bukan pegawai tetap, bukan magang)
   c. Role Admin HRD
   Dashboard hanya berisi kalimat “Selamat Datang [Nama Pengguna] - [Role]”

5) Modul Data Pegawai

Modul data pegawai digunakan untuk pengelolaan data pegawai, yaitu menambahkan
data baru, merubah data, atau menghapus data. Modul data pegawai terdiri dari empat
halaman utama, yaitu halaman daftar pegawai, halaman formulir tambah data baru,
halaman edit data pegawai, dan halaman detail pegawai.

a. Halaman daftar pegawai
Halaman daftar pegawai berisi tabel daftar pegawai dengan ketentuan dan fitur
sebagai berikut.

1. Kolom table:
   ● No. Urut
   ● NIP (Nomor Induk Pegawai) (bisa shorting)
   ● Nama (bisa shorting)
   ● Jabatan (bisa shorting)
   ● Tanggal Masuk (bisa Shorting)
   ● Masa Kerja (bisa shorting)
   ● Aksi:
   ○ Tombol Detail, untuk membuka halaman detail pegawai terpilih
   ○ Tombol Edit, untuk membuka halaman ubah data pegawai terpilih
   ○ Tombol download, untuk mendownload data pegawai (pdf)
   Fitur pada table:
   ○ Shorting pada kolom tertentu
   ○ Paginasi
   ○ Bulk select
2. Tombol-tombol:
   ● Data baru (untuk menuju halaman formulir tambah data baru)
   ● Download pdf, excel (untuk mendownload daftar pegawai)
   ● Hapus data (untuk menghapus data pegawai yang terpilih)
   ● Status (dropdown aktif/nonaktif, untuk mengubah status pegawai terpilih
   sesuai opsi dropdown yang dipilih)
3. Search: Fitur pencarian pegawai dengan parameter: nama/nip/jabatan
4. Filter:
   ● Jabatan: multi select
   ● Masa Kerja: berupa dropdown operator (>, =, <) dan input text number only.
   Misal pengguna memilih operasi > dan mengisikan angka 5 pada input text,
   maka pada table hanya akan tampil pegawai dengan masa kerja lebih dari 5
   tahun.

b. Halaman tambah data baru
Field/Metadata

1. NIP (Minimal 8 karakter, hanya boleh angka, tidak boleh ada spasi)
2. Nama Pegawai (Hanya boleh huruf, angka, dan tanda petik atas (‘) dan spasi)
3. Email (Aturan umum email)
4. Nomor Telepon (Harus menggunakan format internasional, contoh : +6282218458888)
5. Tempat Lahir (Dropdown kabupaten dengan bisa mengetikkan karakter minimal 3 karakter untuk memunculkan autosuggestion)
6. Alamat - Kecamatan (Dropdown autocomplete (minimal 3 karakter),parameternya kecamatan.)
7. Alamat - Kabupaten (Autocomplete, otomatis terisi ketika kecamatan telah dipilih. Fielddisabled.)
8. Alamat - Provinsi (Autocomplete, otomatis terisi ketika kecamatan telah dipilih. Field disabled.)
9. Alamat - Lengkap (Text area)
10. Tanggal Lahir (DD/MM/YYYY)
11. Status Kawin (Radiobutton, “kawin”, “tidak kawin”)
12. Jumlah Anak (Input number only, maksimal 2 digit)
13. Tanggal Masuk (DD/MM/YYYY)
14. JabatanID (select dari table jabatan)
15. DepartemenID (select dari table departemen)
16. Usia (Otomatis terisi ketika pengguna menginputkan tangga masuk. Posisi field disabled)
17. Pendidikan (Form dinamis, bisa menambahkan list pendidikan pada saat input data)
18. Status (Aktif/Nonaktif)

c. Halaman Detail, menampilkan semua informasi dari semua field pada halaman
tambah data baru

d. Halaman Edit, metadata sama seperti metadata pada tambah data baru

6. Setting Tunjangan Transport, digunakan untuk memberikan pengaturan base fare, atau
   tarif tunjangan transport per km.

7. Modul Tunjangan Transport, untuk menampung informasi tunjangan transport
   masing-masing pegawai. Rumus perhitungan tunjangan transport pegawai adalah:
   Tunjangan transport = base fare x km x jumlah hari masuk kerja.
   Pembulatan km mengikuti aturan berikut:

- Jika angka desimal di bawah 0,5 maka dibulatkan ke bawah
- Jika angka desimal adalah 0,5 maka dibulatkan ke atas.
  Aturan hari kerja dalam 1 bulan adalah sebagai berikut:
- Minimal hari masuk kerja agar mendapatkan tunjangan transport adalah 19 hari
  kerja. Jika pegawai hanya masuk kerja 16 hari kerja di bulan berjalan, maka dia
  tidak mendapat tunjangan transport, tanpa mempertimbangan faktor lain
- Jarak maksimal yang dapat diberikan tunjangan adalah 25km. Kelebihan jarak
  tidak dihitung tunjangan.
- Jarak minimal yang dapat diberikan tunjangan adalah 5 km. Jarak 5 km atau
  kurang, tidak dihitung tunjangan.
- Tunjangan transport hanya diberikan kepada pegawai tetap.

8. Modul Log, menyimpan informasi siapa login dan logout kapan, apa modul yang
   diakses, dan aksi apa yang dilakukan pada modul tersebut (create, read, update,
   delete)

9. Buat dokumentasi API, bisa menggunakan tool seperti swagger atau tool lainnya
10. Dokumentasi README tentang setup atau konfigurasi environment
11. Berikan dokumentasi pengujian aplikasi (format bebas sesuai pengetahuan peserta)
