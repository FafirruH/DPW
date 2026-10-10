# Wireframe Jobsheet 12 — Transaksi relasional dan riwayat

Jobsheet 12 melanjutkan aplikasi Toko Madura Jobsheet 11. Dashboard, daftar, login, dan form memakai layout tema yang sama, dengan tambahan pencatatan transaksi berelasi dan halaman riwayat pelanggan.

## Dashboard

```text
TOKO MADURA | Beranda | Barang | Pelanggan | Riwayat Transaksi
             Halo, Nama | Logout
+----------------------------------------------------------------+
| Manajemen Toko Madura                 [+ Barang] [+ Pelanggan]|
| [Total Barang] [Total Pelanggan] [Penghasilan] [Pengeluaran]  |
+----------------------------------------------------------------+
| Stok menipis                      | Transaksi terbaru          |
| nama + jumlah stok                | tanggal + pelanggan/barang |
+----------------------------------------------------------------+
```

## Daftar pelanggan dan pembelian

```text
Daftar Pelanggan                            [+ Tambah Pelanggan]
| Nomor | Nama | Alamat | No. HP | Beli | Edit/Hapus (admin)   |

Modal "Pilih Barang untuk Dibeli"
+---------------------------------------------+
| Nama pelanggan [readonly]                  |
| Barang tersedia [pilih]                    |
| Jumlah pembelian [angka, min 1]             |
|                              [Batal] [Beli] |
+---------------------------------------------+
```

Saat submit, sistem mengecek stok dalam transaksi database, mengunci baris barang dengan `SELECT ... FOR UPDATE`, mengurangi stok, lalu mencatat transaksi dengan `pelanggan_id`, `barang_id`, jumlah, nominal, dan tanggal. Kegagalan membatalkan perubahan melalui rollback.

## Riwayat transaksi pelanggan

```text
Riwayat Pembelian Pelanggan
+-------------------------------------------------------------+
| Pilih Pelanggan [dropdown]          [Tampilkan Riwayat]    |
+-------------------------------------------------------------+
| Tanggal | Barang yang Dibeli | Jumlah | Total Pembayaran    |
| ...                                                        |
+-------------------------------------------------------------+
```

Filter pelanggan dikirim melalui GET. Query `LEFT JOIN` menggabungkan transaksi dengan barang; aturan foreign key `ON DELETE SET NULL` memungkinkan catatan transaksi tetap ada saat data master dihapus.
