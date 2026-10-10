# Wireframe Jobsheet 1 — Struktur HTML SIMPUS

Rancangan ini menggambarkan halaman statis SIMPUS. Angka ringkasan dan data tabel adalah contoh yang ditulis pada HTML; form dan tombol belum menyimpan data.

## Beranda — `index.html`

```text
+------------------------------------------------------------+
| SIMPUS                                                     |
| Beranda | Daftar Buku | Tambah Buku | Daftar Anggota | +   |
+------------------------------------------------------------+
| Selamat Datang di Sistem Perpustakaan Mini                 |
| Aplikasi sederhana untuk mengelola buku dan anggota.       |
+------------------------------------------------------------+
| Ringkasan                                                  |
| +----------------+ +----------------+ +----------------+  |
| | Total Buku     | | Total Anggota  | | Sedang Dipinjam|  |
| |      12        | |       8        | |       3        |  |
| +----------------+ +----------------+ +----------------+  |
+------------------------------------------------------------+
| © 2026 SIMPUS — Jobsheet 1                                  |
+------------------------------------------------------------+
```

## Daftar dan form

```text
Daftar Buku / Daftar Anggota
+------------------------------------------------------------+
| Judul halaman                               [+ Tambah ...] |
+------------------------------------------------------------+
| Tabel contoh:                                               |
| Buku: Judul | Pengarang | Kategori | Tahun | Stok          |
| Anggota: Nama | No. Anggota | Alamat | No. HP              |
+------------------------------------------------------------+

Tambah Buku / Tambah Anggota
+------------------------------------------------------------+
| Judul form                                                 |
| Label + input untuk atribut data                           |
|                                            [Simpan] [Batal]|
+------------------------------------------------------------+
```

## Navigasi dan perilaku

- Navbar menghubungkan beranda, daftar, dan form buku/anggota.
- Tabel, ringkasan, dan tombol masih statis; belum ada pemrosesan server.
