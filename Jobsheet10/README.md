# Manajemen Toko Madura — Autentikasi, Otorisasi & Manajemen Sesi (Jobsheet 10)

Sistem Informasi Manajemen Toko Madura berbasis web yang dibangun menggunakan **PHP Native (PDO)** dan database **PostgreSQL**. Pada Jobsheet 10, aplikasi ini diperbarui dengan mengimplementasikan **Autentikasi (Login/Register)**, **Otorisasi Berbasis Peran / RBAC (Admin dan Tamu(Belum login))**, **Fitur Remember Me**, serta **Proteksi Serangan Brute-Force**.

---

## 📋 Daftar Isi
1. [Fitur Utama & Pembaruan](#1-fitur-utama--pembaruan)
2. [Struktur Proyek](#2-struktur-proyek)
3. [Skema Database (DDL)](#3-skema-database-ddl)
4. [Konsep Dasar: Autentikasi vs Otorisasi](#4-konsep-dasar-autentikasi-vs-otorisasi)
5. [Sistem Keamanan & Fitur Lanjutan](#5-sistem-keamanan--fitur-lanjutan)
   - [5.1 Kriptografi Password (Hashing)](#51-kriptografi-password-hashing)
   - [5.2 Proteksi Brute-Force Login (Maks 3x Attempt)](#52-proteksi-brute-force-login-maks-3x-attempt)
   - [5.3 Sesi & Fitur "Ingat Saya" (Remember Me)](#53-sesi--fitur-ingat-saya-remember-me)
   - [5.4 Guard Clause (`auth.php`)](#54-guard-clause-authphp)
6. [Hak Akses Berbasis Peran (RBAC) & Tampilan Dinamis](#6-hak-akses-berbasis-peran-rbac--tampilan-dinamis)
7. [Panduan Instalasi & Pengujian](#7-panduan-instalasi--pengujian)

---

## 1. Fitur Utama & Pembaruan
- **Dashboard & Arus Kas**: Statistik total barang, pelanggan, dan kalkulasi kas masuk/keluar bulan berjalan secara otomatis.
- **Manajemen Inventaris & Pelanggan**: Sistem CRUD lengkap dengan pencatatan pengeluaran (saat restok barang) dan pemasukan (saat pelanggan membeli barang).
- **Keamanan Kriptografi**: Kata sandi dienkripsi menggunakan fungsi `password_hash()` dan diverifikasi via `password_verify()`.
- **Proteksi Percobaan Login**: Membatasi kesalahan input password maksimal 3 kali untuk mencegah serangan *brute-force*.
- **Fitur "Ingat Saya" (Remember Me)**: Sesi tetap bertahan via *cookie* meskipun peramban (browser) telah ditutup.
- **Otorisasi Berbasis Peran (RBAC)**:
  - **Admin**: Akses penuh ke seluruh fitur (melihat, menambah, mengedit, dan menghapus data barang/pelanggan).
  - **Tamu (Belum Login)**: Hanya dapat mengakses Dashboard (`index.php`) dan Katalog Barang (`barang/list.php`).

---

## 2. Struktur Proyek

```text
Jobsheet10/
├── assets/
│   ├── css/style.css            # Custom UI / Tema Warm Chocolate & Bootstrap
│   └── js/
│       ├── app.js               # Validasi form, filter tabel real-time, toggle navbar
│       ├── barang.js            # Event listener reload halaman barang
│       └── pelanggan.js         # Event listener reload halaman pelanggan
├── auth/                        # MODUL AUTENTIKASI
│   ├── login.php                # Form login + Checkbox Remember Me
│   ├── proses_login.php         # Handler login, validasi password & pembatas 3x percobaan
│   ├── register.php             # Form pendaftaran akun baru
│   ├── proses_register.php      # Handler registrasi + hashing password (default role: admin)
│   └── logout.php               # Penghancur sesi & pembersih cookie
├── barang/                      # MODUL INVENTARIS BARANG
│   ├── list.php                 # Katalog barang (Publik & dinamis sesuai Role)
│   ├── tambah.php               # Form tambah barang (Terkunci)
│   ├── edit.php                 # Form edit barang (Khusus Admin)
│   ├── hapus.php                # Action hapus barang (Khusus Admin)
│   ├── proses_*.php             # Process handlers
│   └── proses_keluar.php        # Handler stok keluar & pencatatan kas
├── pelanggan/                   # MODUL PELANGGAN & TRANSAKSI
│   ├── list.php                 # Tabel pelanggan & modal transaksi (Dinamis sesuai Role)
│   ├── tambah.php               # Form tambah pelanggan (Terkunci)
│   ├── edit.php                 # Form edit pelanggan (Khusus Admin)
│   ├── hapus.php                # Action hapus pelanggan (Khusus Admin)
│   ├── proses_*.php             # Process handlers
│   └── proses_beli.php          # Handler transaksi (Potong stok & catat kas masuk)
├── includes/
│   ├── auth.php                 # Guard clause otorisasi sesi & auto-restore via Cookie
│   ├── header.php               # Navigasi & indikator akun dinamis
│   ├── footer.php               
│   └── koneksi.php              # Koneksi PDO PostgreSQL / Neon DB
├── sql/
│   ├── 01_buku_anggota.sql      # DDL Skema barang, pelanggan, dan transaksi
│   └── 02_users.sql             # DDL Skema tabel users
├── index.php                    # Dashboard utama (Publik)
└── README.md                    # Dokumentasi lengkap

```

---

## 3. Skema Database (DDL)

Tabel `users` digunakan untuk menyimpan credential akun admin.

```sql
-- Skema Tabel Users (Admin)
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'admin'
);

```

**Catatan Skema:**

* `username` menggunakan klausa `UNIQUE` agar tidak ada username duplikat.
* `password` menggunakan `VARCHAR(255)` untuk menampung teks *hash* hasil enkripsi `password_hash()`.
* `role` disetel dengan nilai *default* `'admin'`.

---

## 4. Konsep Dasar: Autentikasi vs Otorisasi

| Istilah | Pertanyaan yang Dijawab | Implementasi di Proyek Ini |
| --- | --- | --- |
| **Autentikasi** (*Authentication*) | "Kamu **siapa**?" | Form Login — Memverifikasi kecocokan username & password pengguna. |
| **Otorisasi** (*Authorization*) | "Kamu **boleh** mengakses apa?" | `includes/auth.php` & Pengecekan `$_SESSION['role']` pada aksi sensitif. |

---

## 5. Sistem Keamanan & Fitur Lanjutan

### 5.1 Kriptografi Password (Hashing)

Aplikasi tidak pernah menyimpan kata sandi mentah (*plaintext*). Pada `auth/proses_register.php`, enkripsi dilakukan dengan:

```php
$stmt->execute([
    'nama'     => $nama,
    'username' => $username,
    'password' => password_hash($password, PASSWORD_DEFAULT),
]);

```

Saat login, verifikasi dilakukan dengan `password_verify($password, $user['password'])`.

### 5.2 Proteksi Brute-Force Login (Maks 3x Attempt)

Pada `auth/proses_login.php`, sistem melacak percobaan login yang gagal berdasarkan username menggunakan array superglobal `$_SESSION['login_attempts']`.

* Jika kesalahan terjadi 3 kali berturut-turut, sistem akan memblokir percobaan login berikutnya dan menampilkan pesan peringatan.
* Jika login berhasil, penghitung kegagalan dihapus (`unset`).

### 5.3 Sesi & Fitur "Ingat Saya" (Remember Me)

Jika pengguna mencentang *checkbox* "Ingat Saya" saat login, sistem akan membuat *cookie* `remember_user` yang berlaku selama 30 hari. File `includes/auth.php` secara otomatis mendeteksi *cookie* tersebut untuk memulihkan sesi pengguna meskipun *browser* pernah ditutup:

```php
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user'])) {
    // Query pengguna berdasarkan ID dari cookie dan pulihkan $_SESSION
}

```

### 5.4 Guard Clause (`auth.php`)

File `includes/auth.php` diletakkan di **baris paling pertama** sebelum output HTML pada berkas yang dikunci. Penggunaan `session_status() === PHP_SESSION_NONE` memastikan `session_start()` tidak dipanggil ganda.

---

## 6. Hak Akses Berbasis Peran (RBAC) & Tampilan Dinamis

Aplikasi menerapkan pembatasan tampilan dan aksi berbasis variabel `$_SESSION['role']`:

1. **Aturan Hapus Data (`hapus.php`)**:
Halaman `barang/hapus.php` dan `pelanggan/hapus.php` dilindungi dengan *guard clause* tambahan:
```php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Akses ditolak: Hanya Admin yang dapat menghapus data.'];
    header('Location: list.php');
    exit;
}

```


2. **Tampilan Tabel Responsif (`list.php`)**:
* Pada **Daftar Barang**, jika pengguna berstatus *Admin* atau *Tamu*, kolom **Aksi** disembunyikan sepenuhnya dari header (`<th>`) dan isi tabel (`<td>`), serta nilai `colspan` pada pesan tabel kosong disesuaikan secara dinamis (7 kolom untuk Admin, 6 kolom untuk Non-Admin).
* Pada **Daftar Pelanggan**, kolom **Aksi** tetap ditampilkan agar *Admin* dapat menekan tombol **"+ Beli Barang"**, sementara tombol **Edit** dan **Hapus** disembunyikan secara khusus dengan tag `<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>`.



---

## 7. Panduan Instalasi & Pengujian

1. **Import Database:**
Eksekusi query DDL pada berkas `sql/01_buku_anggota.sql` dan `sql/02_users.sql` di database PostgreSQL Anda.
2. **Koneksi Database:**
Sesuaikan konfigurasi host, port, database, user, dan password pada file `includes/koneksi.php`.
3. **Jalankan Server:**
Gunakan server lokal PHP atau PHP Built-in Server:
```bash
php -S localhost:8000

```


4. **Skenario Pengujian:**
* **Akses Tanpa Login:** Buka `http://localhost:8000/pelanggan/list.php` -> Sistem otomatis melempar ke halaman Login.
* **Pengujian Brute-Force:** Coba masukan password salah sebanyak 3 kali berturut-turut pada form login -> Sistem akan memblokir akun tersebut dari percobaan selanjutnya.



```

```