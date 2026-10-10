# Wireframe Jobsheet 9 — CRUD barang dan pelanggan

Jobsheet 9 melanjutkan aplikasi inventaris Jobsheet 8 dengan alur edit dan penghapusan master. Menu, daftar, form, dashboard, dan pencatatan transaksi tetap mengikuti tahap sebelumnya; belum ada autentikasi.

## Dashboard dan daftar

```text
TOKO MADURA | Beranda | Barang | Pelanggan
Dashboard: jumlah barang/pelanggan | ringkasan kas | stok kritis

Daftar Barang                                  [+ Tambah Barang]
Tabel: Nama | Produsen | Kategori | Harga | Stok | Edit | Hapus

Daftar Pelanggan                            [+ Tambah Pelanggan]
Tabel: Nomor | Nama | Alamat | No. HP | Edit | Hapus | Beli
```

## Siklus edit

```text
Daftar -> [Edit]
          -> halaman edit? id=<rekaman>
          -> GET rekaman untuk isi awal form
          -> pengguna mengubah field
          -> POST proses_edit.php
          -> validasi + UPDATE ... WHERE id
          -> pesan flash + redirect ke daftar
```

```text
Edit Barang: nama, produsen, tanggal masuk, kode, harga, stok,
             kategori                                   [Simpan]
Edit Pelanggan: nama, nomor pelanggan, alamat, nomor HP [Simpan]
```

Penghapusan pada versi ini menghapus master dan mencoba menghapus catatan transaksi berdasarkan teks di kolom keterangan. Karena tidak ada foreign key pada skema awal, pencocokan teks tersebut tidak sekuat relasi database; Jobsheet 12 memperkenalkan transaksi relasional.
