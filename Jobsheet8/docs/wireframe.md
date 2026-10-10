# Wireframe Jobsheet 8 — Inventaris dan penjualan

Jobsheet 8 memulai aplikasi Toko Madura. Halaman PHP membaca dan menulis PostgreSQL melalui PDO. Belum ada login; transaksi menyimpan keterangan teks dan belum memiliki foreign key ke barang/pelanggan.

## Dashboard — `index.php`

```text
+----------------------------------------------------------------+
| TOKO MADURA             Beranda | Barang | Pelanggan           |
+----------------------------------------------------------------+
| Manajemen Toko Madura                  [+ Barang] [+ Pelanggan]|
+----------------------------------------------------------------+
| Ringkasan Keuangan & Stok                                     |
| [Total Barang] [Total Pelanggan] [Penghasilan] [Pengeluaran]  |
+----------------------------------------------------------------+
| Peringatan stok menipis          | Transaksi kas terbaru       |
| nama barang — sisa/habis         | tanggal | keterangan | Rp   |
+----------------------------------------------------------------+
| Footer Jobsheet 8                                               |
+----------------------------------------------------------------+
```

## Daftar barang dan pelanggan

```text
Daftar Barang                                  [+ Tambah Barang]
Tabel: Nama | Produsen | Kategori | Tgl Masuk | Harga | Stok
       | Aksi barang keluar/hapus (sesuai halaman)

Daftar Pelanggan                            [+ Tambah Pelanggan]
Tabel: No. Pelanggan | Nama | Alamat | No. HP | Aksi
       | aksi beli barang (jika tersedia pada halaman)
```

## Form dan transaksi

```text
Tambah Barang: nama, produsen, tanggal masuk, kode, harga, stok,
               kategori                                      [Simpan]
Tambah Pelanggan: nama, nomor pelanggan, alamat, nomor HP     [Simpan]

Pembelian: pilih pelanggan/barang, isi jumlah
           -> cek stok -> kurangi stok -> catat kas masuk
Barang keluar: isi jumlah -> cek stok -> kurangi stok
               -> catat kas masuk
```

Tambah stok barang mencatat modal sebagai pengeluaran. Aksi yang mengubah stok dan mencatat nominal dibungkus dalam transaksi PDO agar perubahan terkait dapat commit atau rollback bersama. Form dan handler melakukan validasi di server; query memakai prepared statement.
