# Wireframe Jobsheet 6 — Data JSON dan `fetch()`

Jobsheet 6 mengisi tabel buku dan anggota dari file JSON dengan JavaScript. Beranda dan form tetap halaman HTML; proses daftar membutuhkan web server lokal agar `fetch()` dapat membaca file data.

## Halaman daftar saat memuat data

```text
+------------------------------------------------------------+
| SIMPUS                                  [☰ Menu]           |
| Daftar Buku | Daftar Anggota                               |
+------------------------------------------------------------+
| Daftar Buku                                  [+ Tambah]    |
| Cari judul: [____________________________]                 |
+------------------------------------------------------------+
| [Memuat data...]                                            |
| Tabel: Judul | Pengarang | Kategori | Tahun | Stok | Aksi  |
| (baris dimasukkan ke tbody setelah JSON diterima)           |
+------------------------------------------------------------+
| Jika fetch gagal: pesan error pada area tabel               |
| Footer Jobsheet 6                                           |
+------------------------------------------------------------+
```

## Alur render daftar

```text
Halaman dibuka
   -> skrip buku.js / anggota.js meminta data/*.json
   -> tampilkan indikator loading
   -> parse respons JSON
   -> buat baris DOM dan isi tbody
   -> tampilkan pesan bila request gagal
```

Pemuatan terjadi otomatis ketika halaman daftar dibuka; tidak ada tombol muat ulang terpisah. Tombol aksi yang tampil belum terhubung ke penyimpanan server.
