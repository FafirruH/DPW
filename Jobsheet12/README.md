# Manajemen Toko Madura — Integrasi Relasi & Transaksi Lanjutan (Jobsheet 12)

Pada pembaruan Jobsheet 12, sistem kasir Toko Madura merombak struktur pencatatan transaksi dari yang sebelumnya berupa teks mentah (kaku) menjadi **Tabel Relasional Terintegrasi** menggunakan PostgreSQL. 

## 1. Fitur Utama Pembaruan
- **Foreign Key (`ON DELETE SET NULL`)**: Tabel `transaksi` kini memiliki relasi langsung ke tabel `pelanggan` dan `barang`. Jika pelanggan/barang dihapus, histori keuangan tidak akan cacat (uang tidak menguap), melainkan data entitasnya diset menjadi `NULL`.
- **Riwayat Transaksi Dinamis (`JOIN`)**: Menambahkan modul baru `transaksi/riwayat.php` yang memanfaatkan SQL `LEFT JOIN` untuk menggabungkan 3 tabel sekaligus (Transaksi, Pelanggan, Barang) agar dapat disaring berdasarkan histori belanja masing-masing anggota.
- **Transaction & Konkurensi (`FOR UPDATE`)**: Pembelian yang memotong stok dibungkus dalam blok `$pdo->beginTransaction()` dan diamankan menggunakan `SELECT ... FOR UPDATE` untuk menghindari *Race Condition* saat dua petugas kasir memproses barang yang sama secara bersamaan.
- **Dashboard Relasional**: Daftar "Transaksi Terbaru" di halaman Beranda kini menarik nama Pelanggan dan Barang secara *real-time* dari tabel aslinya menggunakan `JOIN`, menggantikan teks keterangan pasif.

## 2. Struktur Modul Baru
```text
Jobsheet11 (Termasuk Update Jobsheet 12)/
├── transaksi/
│   └── riwayat.php              # Halaman baru untuk melihat histori pembelian pelanggan
├── sql/
│   └── 03_transaksi_relasi.sql  # DDL pembongkaran dan pembuatan tabel relasi transaksi
```

### Penjelasan Konsep Inti Jobsheet 12: Relasi & Transaksi Lanjutan

Pembaruan pada Jobsheet 12 tidak hanya sekadar mengubah tampilan web, melainkan merombak arsitektur basis data (database) menjadi lebih tangguh, efisien, dan aman dari anomali data. Berikut adalah 4 konsep utama yang diterapkan:

#### 1. Transisi ke Tabel Relasional (Foreign Key)

Pada sistem sebelumnya, saat terjadi transaksi, aplikasi menyimpan data mentah berupa teks (misal: `"Penjualan ke Budi: Gula (2 pcs)"`). Cara ini disebut *data redundancy* (pengulangan data) dan sangat sulit jika kita ingin menyaring (filter) laporan khusus untuk Budi saja.

* **Solusi:** Kita mengubah tabel `transaksi` menjadi tabel relasional. Kita tidak lagi menyimpan teks nama, melainkan menyimpan **ID Pelanggan** dan **ID Barang** (sebagai *Foreign Key*).
* **Manfaat:** Database menjadi lebih ringan, terstruktur, dan pencarian data spesifik (misal: histori belanja satu pelanggan tertentu) bisa dilakukan jauh lebih cepat.

#### 2. Menyatukan Data dengan SQL `JOIN`

Karena tabel `transaksi` kini hanya berisi angka ID, data tersebut tidak bermakna jika langsung ditampilkan ke layar kasir. Kita harus menerjemahkan ID tersebut kembali menjadi "Nama Pelanggan" dan "Nama Barang".

* **Implementasi:** Pada file `transaksi/riwayat.php` dan `index.php`, kita menggunakan perintah `LEFT JOIN`. Perintah ini bertugas "menjahit" atau menggabungkan tabel `transaksi`, `pelanggan`, dan `barang` secara bersamaan berdasarkan kecocokan ID-nya, sehingga aplikasi bisa mencetak nama asli entitas tersebut ke layar secara *real-time*.

#### 3. Database Transaction & Mencegah *Race Condition* (`FOR UPDATE`)

Saat ada pelanggan membeli barang, ada dua peristiwa yang harus terjadi di database: (1) Uang kas bertambah, dan (2) Stok barang berkurang.
Bagaimana jika saat server sedang memproses langkah 1, tiba-tiba listrik mati sehingga langkah 2 gagal tereksekusi? Sistem akan menjadi tidak konsisten (uang masuk, tapi stok tidak berkurang).

* **Solusi `Transaction`:** Kita membungkus kedua proses tersebut di dalam blok `$pdo->beginTransaction()` dan `$pdo->commit()`. Jika salah satu gagal, sistem akan memicu `$pdo->rollBack()` yang membatalkan seluruh proses seolah-olah tidak pernah terjadi sama sekali.
* **Solusi `FOR UPDATE` (*Race Condition*):** Bayangkan stok rokok sisa 1. Kasir A dan Kasir B menekan tombol "Beli" di detik dan milidetik yang sama persis. Tanpa proteksi, keduanya bisa berhasil memotong stok sehingga stok menjadi `-1`. Klausa `SELECT ... FOR UPDATE` akan mengunci baris barang tersebut. Jika Kasir A sedang memproses, Kasir B harus "mengantre" sepersekian detik sampai proses A selesai. Saat giliran B tiba, sistem akan melihat bahwa stok sudah `0` dan otomatis menolak transaksi B.

#### 4. Integritas Data Keuangan (`ON DELETE SET NULL`)

Apa yang terjadi pada laporan keuangan bulanan jika admin menghapus data "Budi" dari daftar pelanggan? Jika kita menggunakan relasi yang kaku (*Cascade*), seluruh riwayat transaksi Budi akan ikut terhapus, menyebabkan total pendapatan toko tiba-tiba menyusut dan laporan kas menjadi kacau.

* **Solusi:** Kita menerapkan aturan `ON DELETE SET NULL` pada *Foreign Key* di tabel transaksi.
* **Efeknya:** Saat data Budi dihapus dari master pelanggan, data uang dan barang yang pernah ia beli **tetap ada** di tabel transaksi. Hanya saja, kolom `pelanggan_id`-nya berubah menjadi kosong (`NULL`). Transaksi tersebut berubah menjadi transaksi "Anonim/Umum", sehingga saldo kas toko tetap akurat.