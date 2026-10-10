# Wireframe Jobsheet 5 — Bootstrap dan interaksi JavaScript

Jobsheet 5 tetap berupa SIMPUS sisi browser. Bootstrap membentuk komponen responsif, CSS kustom mengatur tema, dan JavaScript menambahkan interaksi ringan. Tidak ada login atau penyimpanan database.

## Beranda

```text
+------------------------------------------------------------+
| SIMPUS                                  [☰ Menu]           |
| Daftar Buku | Daftar Anggota                               |
+------------------------------------------------------------+
| Sambutan + deskripsi                                       |
+------------------------------------------------------------+
| [Total Buku]       [Total Anggota]       [Peminjaman]      |
+------------------------------------------------------------+
| Footer Jobsheet 5                                           |
+------------------------------------------------------------+
```

## Daftar buku/anggota

```text
+------------------------------------------------------------+
| Navbar (menu daftar buku dan daftar anggota)                |
+------------------------------------------------------------+
| Daftar ...                                 [+ Tambah ...]  |
| Cari: [____________________________]                       |
+------------------------------------------------------------+
| Data contoh dalam tabel                                    |
| Kolom ...                               [Edit] [Hapus]     |
+------------------------------------------------------------+
```

## Form input

```text
Tambah Buku / Tambah Anggota
+------------------------------------------------------------+
| Label + input teks                                         |
| Label + input angka/tanggal/pilihan                        |
| Pesan validasi sisi browser bila input tidak sesuai        |
|                                      [Simpan] [Batal]      |
+------------------------------------------------------------+
```

JavaScript dapat memfilter tabel, memvalidasi input, mengonfirmasi aksi, atau membuka menu. Konfirmasi/hapus pada tahap ini hanya interaksi browser; data contoh tidak dikirim ke backend.
