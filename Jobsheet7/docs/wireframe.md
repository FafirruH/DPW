# Wireframe Jobsheet 7 — PHP dan session

Jobsheet 7 memindahkan SIMPUS ke halaman PHP yang dirender server. Data CRUD disimpan dalam `$_SESSION`, bukan file JSON atau database. Login tidak termasuk dalam tahap ini.

## Beranda dan daftar

```text
+------------------------------------------------------------+
| SIMPUS                                  Menu               |
| Beranda | Daftar Buku | Daftar Anggota                     |
+------------------------------------------------------------+
| Beranda: pengantar + ringkasan                             |
+------------------------------------------------------------+
| Footer Jobsheet 7                                           |
+------------------------------------------------------------+

Daftar Buku / Daftar Anggota                [+ Tambah]
+------------------------------------------------------------+
| Pesan status sekali tampil (jika ada)                       |
| Tabel dari array session                                   |
| Data ...                                      [Edit][Hapus]|
+------------------------------------------------------------+
```

## Form dan alur POST

```text
Form Tambah / Edit Buku atau Anggota
+------------------------------------------------------------+
| Pesan validasi                                             |
| Label + nilai awal/input                                   |
| Hidden ID dan jenis aksi bila diperlukan                  |
|                                      [Simpan] [Kembali]    |
+------------------------------------------------------------+
```

```text
Form POST -> proses_tambah.php
           -> validasi + ubah array $_SESSION
           -> simpan pesan flash
           -> redirect ke daftar -> render ulang tabel
```

Menghapus cookie session atau memulai session baru membuat aplikasi tidak lagi membaca data session yang lama. Data contoh JSON yang mungkin berada di folder `data/` bukan sumber CRUD Jobsheet 7.
