# Wireframe & User Flow — SIMPUS

Sub-CPMK: Merancang UI/UX aplikasi (proyek).

Halaman yang sudah ada (Beranda, Daftar/Tambah Buku, Daftar/Tambah Anggota — Jobsheet 1-3) belum mencakup fitur Login, Dashboard Petugas, dan Peminjaman/Pengembalian. Dokumen ini merancang wireframe untuk halaman-halaman tersebut sebelum diimplementasikan mulai Jobsheet 5 dan seterusnya.

## Aktor
- **Tamu**: hanya bisa melihat katalog buku (Beranda, Daftar Buku) tanpa login.
- **Petugas**: login untuk mengakses seluruh fitur CRUD dan transaksi peminjaman.

## User Flow — Peminjaman Buku

```
[Petugas Login] -> [Dashboard] -> [Pilih menu "Peminjaman Baru"]
        -> [Pilih Anggota] -> [Pilih Buku (stok > 0)]
        -> [Simpan] -> [Stok buku berkurang 1] -> [Kembali ke Dashboard]
```

## User Flow — Pengembalian Buku

```
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/buku)]
        -> [Tandai "Dikembalikan"] -> [Stok buku bertambah 1]
        -> [Kembali ke Dashboard]
```

## Wireframe: Halaman Login

```
+--------------------------------------+
|              SIMPUS                  |
|--------------------------------------|
|                                      |
|        [ Login Petugas ]             |
|                                      |
|   Username : [______________]        |
|   Password : [______________]        |
|                                      |
|          [   Masuk   ]               |
|                                      |
|   Belum punya akun? Daftar di sini   |
+--------------------------------------+
```

## Wireframe: Dashboard Petugas

```
+---------------------------------------------------------------------------+
| SIMPUS      Beranda | Buku | Anggota | Peminjaman | (Nama Petugas) Logout |
|---------------------------------------------------------------------------|
|  [Total Buku]   [Total Anggota]   [Sedang Dipinjam]                       |
|                                                                           |
|  Aksi Cepat:                                                              |
|  [ + Peminjaman Baru ]   [ + Pengembalian ]                               |
|                                                                           |
|  Transaksi Terbaru                                                        |
|  -----------------------------------------------------------------------  |
|  Anggota | Buku | Tgl Pinjam | Status                                     |
+---------------------------------------------------------------------------+
```

## Wireframe: Form Peminjaman

```
+--------------------------------------+
|  Form Peminjaman Buku                |
|--------------------------------------|
|  Anggota : [ dropdown pilih anggota ]|
|  Buku    : [ dropdown, hanya stok>0 ]|
|  Tanggal Pinjam : [ auto: hari ini ] |
|                                      |
|          [  Simpan Peminjaman  ]     |
+--------------------------------------+
```

## Wireframe: Form Pengembalian

```
+---------------------------------------------+
|  Pengembalian Buku                          |
|---------------------------------------------|
|  Cari transaksi aktif:                      |
|  [ nama anggota / judul buku ______ ]       |
|                                             |
|  Anggota | Buku | Tgl Pinjam | [Kembalikan] |
+---------------------------------------------+
```

## Wireframe: Riwayat Peminjaman per Anggota

```
+-------------------------------------------------------+
|  Riwayat Peminjaman — Siti Aminah                     |
|-------------------------------------------------------|
|  Buku             | Pinjam   | Kembali | Status       |
|  Laskar Pelangi   | 01/07    | 10/07   | Selesai      |
|  Bumi Manusia     | 15/07    | -       | Dipinjam     |
+-------------------------------------------------------+
```

## Konsistensi dengan Desain yang Sudah Berjalan
- Warna aksen, tipografi navbar, dan gaya tabel/kartu mengikuti `assets/css/style.css` yang sudah dibangun sejak Jobsheet 2-3.
- Navbar akan ditambah menu **Peminjaman** dan indikator status login (nama petugas / tombol Logout) mulai implementasi di Jobsheet 10.
- Edge case yang perlu ditangani saat implementasi: buku stok habis tidak boleh dipilih di form peminjaman; anggota dengan tunggakan terlambat divalidasi di Jobsheet 12 (tugas mandiri).


# Wireframe & User FlowTambahan — SIMPUS

## 1. Wireframe: Registrasi Anggota Baru (Aktor: Tamu)

```text
+-----------------------------------------------------+
| SIMPUS        Beranda | Buku | Registrasi | Login   |
|-----------------------------------------------------|
|                                                     |
|            [ Registrasi Anggota Baru ]              |
|                                                     |
|   Nama Lengkap    : [________________________]      |
|   Nomor Identitas : [ NIK / NIM / NIS _______]      |
|   Nomor HP/WA     : [________________________]      |
|   Alamat Lengkap  : [________________________]      |
|                     [________________________]      |
|   Email           : [________________________]      |
|   Kata Sandi      : [________________________]      |
|   Konfirmasi Sandi: [________________________]      |
|                                                     |
|                  [  Daftar Sekarang  ]              |
|                                                     |
|   Sudah punya akun? Login di sini                   |
+-----------------------------------------------------+
```

## 2. User Flow Tambahan

### A. User Flow: Pencarian Anggota Menunggak / Jatuh Tempo

[Petugas Login] -> [Dashboard] -> [Pilih menu "Laporan / Peminjaman"]
        -> [Klik Filter "Tunggakan / Terlambat"] 
        -> [Sistem menampilkan daftar transaksi yang melewati tanggal jatuh tempo]
        -> [Petugas memilih Anggota] -> [Lihat Rincian Denda / Kirim Pengingat]

### B. User Flow: Registrasi Anggota Baru oleh Tamu

[Tamu Buka Web] -> [Pilih menu "Registrasi"] -> [Mengisi Form Data Diri & Akun]
        -> [Klik "Daftar Sekarang"] -> [Sistem Validasi Input]
        -> [Akun Terbuat (Status: Pending/Aktif)] -> [Redireksi ke Halaman Login]

## 3. Identifikasi Edge Cases Tambahan

### 1. Peminjaman Ganda Buku yang Sama oleh Anggota yang Sama
    - Kondisi: Petugas mencoba meminjamkan buku Bumi Manusia ke Siti    Aminah, padahal Siti Aminah masih meminjam eksemplar buku Bumi Manusia tersebut dan belum mengembalikannya.

    - Solusi/Aturan: Sistem menolak transaksi dan menampilkan pesan eror: "Anggota ini masih meminjam eksemplar buku yang sama."

### 2. Buku dengan Stok Habis ($0$) Muncul di Form Peminjaman
    - Kondisi: Stok buku di basis data tinggal $0$, namun dipilih oleh Petugas saat peminjaman.
    - Solusi/Aturan: Filter pada dropdown pilihan buku secara otomatis menyembunyikan (disable/filter out) buku yang berstok $0$.

### 3. Anggota Mencapai Batas Maksimal Peminjaman
    - Kondisi: Anggota sudah meminjam $3$ buku (batas maksimum per transaksi), lalu mencoba meminjam $1$ buku lagi.
    - Solusi/Aturan: Sistem memblokir peminjaman baru sampai salah satu buku yang sedang dipinjam dikembalikan terlebih dahulu.

### 4. Pendaftaran Akun Baru dengan Nomor HP / Email yang Sudah Terdaftar
    - Kondisi: Tamu mendaftar akun baru menggunakan Email atau Nomor HP yang sudah terdaftar di basis data anggota.
    - Solusi/Aturan: Sistem menampilkan pesan peringatan: "Email/Nomor HP sudah terdaftar. Silakan gunakan menu Login."


# Implementasi Kode HTML Statis Login (login.html)

```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPUS | Login Petugas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>SIMPUS</h1>
        <nav>
            <ul>
                <li><a href="index.html">Beranda</a></li>
                <li><a href="buku/list.html">Daftar Buku</a></li>
                <li><a href="login.html">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section style="max-width: 450px; margin: 2rem auto;">
            <h2>Login Petugas</h2>
            <form action="dashboard.html" method="POST">
                <p>
                    <label for="username">Username</label><br>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                </p>
                <p>
                    <label for="password">Password</label><br>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </p>
                <p>
                    <button type="submit">Masuk</button>
                </p>
            </form>
            <p style="margin-top: 1rem; font-size: 0.9rem;">
                Belum punya akun? <a href="registrasi.html">Daftar di sini</a>
            </p>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIMPUS &mdash; Jobsheet 4</p>
    </footer>
</body>
</html>
```