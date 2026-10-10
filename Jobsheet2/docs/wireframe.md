# Wireframe Jobsheet 2 — SIMPUS dengan CSS terpisah

Jobsheet 2 mempertahankan struktur dan konten statis Jobsheet 1. Perubahan utamanya adalah aturan visual dipindahkan ke `assets/css/style.css`; susunan area halaman masih sama.

## Beranda

```text
+------------------------------------------------------------+
| SIMPUS                                      Navigasi       |
+------------------------------------------------------------+
| Sambutan / deskripsi singkat                                |
+------------------------------------------------------------+
| Ringkasan                                                   |
| +----------------+ +----------------+ +----------------+  |
| | Total Buku     | | Total Anggota  | | Dipinjam       |  |
| +----------------+ +----------------+ +----------------+  |
+------------------------------------------------------------+
| Footer: SIMPUS — Jobsheet 2                                 |
+------------------------------------------------------------+
```

## Daftar dan form

```text
Daftar Buku / Anggota                       [Tambah data]
+------------------------------------------------------------+
| Tabel statis dengan header dan baris contoh                 |
| Judul/Nama | Atribut terkait | Tahun/Alamat | Stok/No. HP  |
+------------------------------------------------------------+

Form Tambah Buku / Anggota
+------------------------------------------------------------+
| Judul halaman                                               |
| Label input                                                 |
| Label input                                                 |
| Label pilihan / input tambahan                              |
|                                       [Simpan] [Kembali]    |
+------------------------------------------------------------+
```

`style.css` memberi gaya bersama pada header, navigasi, konten, kartu, tabel, form, tombol, dan footer. Tautan ant halaman tetap menjadi navigasi utama; isi masih statis dan belum disimpan.
