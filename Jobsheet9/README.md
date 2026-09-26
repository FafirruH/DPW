1. **Dashboard / Beranda Keuangan**:
   - Menampilkan total jenis barang dan pelanggan terdaftar.
   - Ringkasan pemasokan kas dan pengeluaran kas otomatis bulan berjalan.
   - Peringatan (*alert*) otomatis untuk stok barang kritis ($\le 5$ pcs atau habis).
   - Riwayat 5 transaksi kas terbaru.
2. **Manajemen Barang (CRUD Complete)**:
   - Inventarisasi data barang (Nama Barang, Produsen/Merek, Tanggal Masuk, Kode/Barcode, Harga, Stok, dan Kategori).
   - **Fitur Tambah & Catat Kas**: Pencatatan transaksi pengeluaran kas otomatis setiap penambahan stok/barang baru.
   - **Fitur Edit Barang**: Pembaruan data spesifikasi, harga, maupun stok barang secara dinamis.
   - **Fitur Hapus Barang**: Membersihkan data barang beserta riwayat transaksi terkait.
3. **Manajemen Pelanggan & Penjualan Direct (CRUD Complete)**:
   - Pengelolaan data pelanggan lengkap (*No. Pelanggan*, Nama, Alamat, No. HP).
   - **Fitur Edit Pelanggan**: Mengubah profil dan identitas kontak pelanggan.
   - *Modal* interaktif untuk memproses transaksi pembelian barang oleh pelanggan secara langsung (ototmatis memotong stok & mencatat kas masuk).

---

## Struktur Direktori Proyek

```text
Jobsheet9/
├── assets/
│   ├── css/
│   │   └── style.css           # Custom UI / Tema Warm Chocolate
│   └── js/
│       ├── app.js              # Validasi form, filter tabel, toggle navbar
│       ├── barang.js           # Event listener muat ulang barang
│       └── pelanggan.js        # Event listener muat ulang pelanggan
├── barang/
│   ├── edit.php                # Form edit data barang
│   ├── hapus.php               # Hapus barang & riwayat transaksinya
│   ├── list.php                # Tabel inventaris barang
│   ├── proses_edit.php         # Handler pembaruan data barang
│   ├── proses_keluar.php       # Form handler barang keluar
│   ├── proses_tambah.php       # Form handler tambah barang & catat pengeluaran
│   └── tambah.php              # Form input barang baru
├── includes/
│   ├── footer.php              # Layout footer & script bootstrap
│   ├── header.php              # Header, Navbar & pemanggilan style.css
│   └── koneksi.php             # Koneksi PDO PostgreSQL / Neon Database
├── pelanggan/
│   ├── edit.php                # Form edit data pelanggan
│   ├── hapus.php               # Hapus pelanggan & riwayat transaksinya
│   ├── list.php                # Tabel pelanggan & Modal Transaksi Pembelian
│   ├── proses_beli.php         # Handler transaksi beli (Potong stok & catat kas masuk)
│   ├── proses_edit.php         # Handler pembaruan data pelanggan
│   ├── proses_tambah.php       # Handler tambah data pelanggan
│   └── tambah.php              # Form input pelanggan baru
├── barang_pelanggan_transaksi.sql # DDL Schema Database PostgreSQL
├── index.php                   # Dashboard utama & statistik
└── README.md                   # Dokumentasi proyek
```

## Skema Database (PostgreSQL)
```SQL
CREATE TABLE IF NOT EXISTS barang (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    produsen VARCHAR(255) NOT NULL,
    tahun VARCHAR(50) NOT NULL,
    kode VARCHAR(50),
    harga NUMERIC NOT NULL DEFAULT 0,
    stok INTEGER NOT NULL DEFAULT 0,
    kategori VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS pelanggan (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    no_pelanggan VARCHAR(50) NOT NULL UNIQUE,
    alamat VARCHAR(255),
    no_hp VARCHAR(30)
);

CREATE TABLE IF NOT EXISTS transaksi (
    id SERIAL PRIMARY KEY,
    jenis VARCHAR(20) NOT NULL, -- 'masuk' (pemasokan) atau 'keluar' (pengeluaran)
    nominal NUMERIC NOT NULL DEFAULT 0,
    keterangan VARCHAR(255),
    tanggal DATE NOT NULL DEFAULT CURRENT_DATE
);
```

## Penjelasan Sintaks & Fitur Edit (Sarana Belajar)
1. Penjelasan Alur Fitur Edit Barang (barang/edit.php & barang/proses_edit.php)
Fitur Edit menggunakan kombinasi metode GET untuk mengambil data lama dan POST untuk menyimpan perubahan.

### Mengambil Data Lama (GET):
```
PHP
// barang/edit.php
$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM barang WHERE id = :id");
$stmt->execute(['id' => (int)$id]);
$barang = $stmt->fetch(PDO::FETCH_ASSOC);
```
Sintaks di atas mengambil ID dari URL, mencari data barang terkait di database, lalu mengisikannya ke variabel $barang untuk ditampilkan pada atribut value="..." pada form input.


### Memproses Pembaruan Data (POST):
```
PHP
// barang/proses_edit.php
$stmt = $pdo->prepare("
    UPDATE barang 
    SET nama = :nama, produsen = :produsen, tahun = :tahun, 
        kode = :kode, harga = :harga, stok = :stok, kategori = :kategori 
    WHERE id = :id
");
```

### Query UPDATE dijalankan menggunakan Prepared Statement untuk memperbarui nilai kolom pada tabel barang secara aman berdasarkan id barang.

## 2. Penjelasan Alur Fitur Edit Pelanggan (pelanggan/edit.php & pelanggan/proses_edit.php)
Form Edit Pelanggan (pelanggan/edit.php):
Form menerima data id melalui hidden input (<input type="hidden" name="id" value="...">) agar ID pengguna tetap terikat saat form dikirimkan melalui metode POST.

### Handler Edit Pelanggan (pelanggan/proses_edit.php):
```
PHP
$stmt = $pdo->prepare("
    UPDATE pelanggan 
    SET nama = :nama, no_pelanggan = :no_pelanggan, 
        alamat = :alamat, no_hp = :no_hp 
    WHERE id = :id
");
```

Menjalankan perintah SQL untuk mengubah nama, nomor pelanggan, alamat, atau nomor HP pelanggan berdasarkan ID uniknya.