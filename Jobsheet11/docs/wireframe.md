# Wireframe Jobsheet 11 — Output dan request yang dilindungi

Jobsheet 11 meneruskan halaman autentikasi dan inventaris Jobsheet 10, lalu menambahkan escaping output dan token CSRF pada form/handler yang memasangnya. Susunan visual utama tidak berubah; wireframe ini menandai titik perlindungan pada alur.

## Form yang mengubah data

```text
Tambah / Edit Barang atau Pelanggan
+--------------------------------------------------+
| Pesan status/validasi                            |
| Label + input                                    |
| [hidden csrf_token]                              |
|                                  [Simpan]        |
+--------------------------------------------------+
```

```text
Daftar
| Rekaman | [Edit] | [Form POST + csrf_token: Hapus] |
```

## Alur request

```text
GET form -> PHP membuat/mengambil token di session
         -> csrf_field() memasukkan token tersembunyi
POST form -> auth guard (jika diperlukan)
          -> csrf_verify() memeriksa token dengan hash_equals()
          -> validasi input -> query database -> redirect/pesan
```

Nilai dinamis yang ditampilkan di HTML di-escape dengan helper `e()`. Penghapusan memakai POST dan, pada handler yang sesuai, pemeriksaan role. Token tidak melindungi otomatis: hanya aksi dengan field token dan pemanggilan verifikasi yang memiliki perlindungan CSRF.
