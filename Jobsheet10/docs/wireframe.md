# Wireframe Jobsheet 10 — Autentikasi dan akses

Jobsheet 10 menambahkan registrasi, login, session, guard, dan tombol Login/Logout ke aplikasi Toko Madura. Halaman manajemen menggunakan tema cokelat; detail CRUD mengikuti rancangan Jobsheet 9.

## Navbar dan halaman aplikasi

```text
Belum login:
+-------------------------------------------------------------+
| TOKO MADURA     Beranda | Barang                   [Login]  |
+-------------------------------------------------------------+

Sudah login:
+-------------------------------------------------------------+
| TOKO MADURA     Beranda | Barang | Pelanggan  Halo, Nama [Logout] |
+-------------------------------------------------------------+

Beranda: ringkasan stok/kas + aktivitas terbaru
Barang/Pelanggan: daftar dan form CRUD sesuai hak alur yang ada
```

## Login dan registrasi

```text
Login Petugas
+------------------------------------+
| Username [____________________]    |
| Password [____________________]    |
| [ ] Ingat Saya                     |
|              [Masuk Sekarang]      |
| Belum punya akun? [Daftar di sini] |
+------------------------------------+

Registrasi
+------------------------------------+
| Nama lengkap [_______________]     |
| Username     [_______________]     |
| Password     [_______________]     |
|              [Daftar]              |
+------------------------------------+
```

Registrasi menyimpan hash password; login memverifikasinya, mengisi identitas/role di session, dan guard mengarahkan pengguna anonim ke halaman login. Checkbox “Ingat Saya” memakai cookie untuk memulihkan session. Percobaan gagal ditampilkan sebagai pesan pada form login.
