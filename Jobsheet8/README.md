Berikut adalah dokumentasi lengkap dan panduan yang disajikan dalam berkas **`README.md`**. File ini sudah mencakup penjelasan arsitektur, skema database, alur transaksi kas otomatis, hingga panduan tiap file kode untuk sarana belajar.

---

# `README.md`

# Aplikasi Manajemen Toko Madura

Aplikasi berbasis web menggunakan **PHP Native** dan database **PostgreSQL (PDO)** yang dirancang untuk membantu pengelolaan persediaan barang, data pelanggan, pencatatan transaksi masuk (penjualan), dan pengeluaran kas (stok masuk) secara otomatis.

---

## Ringkasan Fitur

1. **Dashboard / Beranda Keuangan**:
   - Menampilkan total jenis barang dan pelanggan.
   - Ringkasan pemasokan kas dan pengeluaran kas otomatis bulan berjalan.
   - Peringatan (*alert*) otomatis untuk stok barang kritis ($\le 5$ pcs atau habis).
   - Riwayat 5 transaksi kas terbaru.
2. **Manajemen Barang**:
   - Inventarisasi data barang (Nama Barang, Produsen/Merek, Tanggal Masuk, Kode/Barcode, Harga, Stok, dan Kategori).
   - Pencatatan transaksi **Pengeluaran Kas** otomatis setiap penambahan stok/barang baru.
   - Hapus barang yang secara cascading membersihkan riwayat transaksi terkait.
3. **Manajemen Pelanggan & Penjualan Direct**:
   - Pengelolaan data pelanggan lengkap (*No. Pelanggan*, Nama, Alamat, No. HP).
   - *Modal* interaktif untuk memproses transaksi pembelian barang oleh pelanggan secara langsung.
   - Pembetulan/pembaharuan stok barang dan pencatatan **Pemasokan Kas** secara otomatis.

---

## Struktur Direktori Proyek

```
Jobsheet8/
├── assets/
│   ├── css/
│   │   └── style.css           # Custom UI / Tema Warm Chocolate
│   └── js/
│       ├── app.js              # Validasi form, filter tabel, toggle navbar
│       ├── barang.js           # Event listener muat ulang barang
│       └── pelanggan.js        # Event listener muat ulang pelanggan
├── barang/
│   ├── hapus.php               # Hapus barang & riwayat transaksinya
│   ├── list.php                # Tabel inventaris barang
│   ├── proses_keluar.php       # Form handler barang keluar
│   ├── proses_tambah.php       # Form handler tambah barang & catat pengeluaran
│   └── tambah.php              # Form input barang baru
├── includes/
│   ├── footer.php              # Layout footer & script bootstrap
│   ├── header.php              # Header, Navbar & pemanggilan style.css
│   └── koneksi.php             # Koneksi PDO PostgreSQL / Neon Database
├── pelanggan/
│   ├── hapus.php               # Hapus pelanggan & riwayat transaksinya
│   ├── list.php                # Tabel pelanggan & Modal Transaksi Pembelian
│   ├── proses_beli.php         # Handler transaksi beli (Potong stok & catat kas masuk)
│   ├── proses_tambah.php       # Handler tambah data pelanggan
│   └── tambah.php              # Form input pelanggan baru
├── barang_pelanggan_transaksi.sql # DDL Schema Database PostgreSQL
├── index.php                   # Dashboard utama & statistik
└── README.md                   # Dokumentasi proyek

```

---

## Skema Database (PostgreSQL)

Database menggunakan 3 tabel utama yang saling berelasi secara logis melalui alur transaksi:

```sql
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

---

## Penjelasan Kode Lengkap & Sarana Belajar

### 1. File Database & Konfigurasi

#### `barang_pelanggan_transaksi.sql`

Menampung query DDL pembuatan tabel di PostgreSQL:

* **`barang`**: Menyimpan produk, merek (`produsen`), kode/barcode, harga, dan stok.
* **`pelanggan`**: Menyimpan identitas pembeli dengan `no_pelanggan` sebagai identifier unik (`UNIQUE`).
* **`transaksi`**: Menjadi buku kas terpusat. Kolom `jenis` menampung nilai `'masuk'` (pendapatan/penjualan) atau `'keluar'` (pengeluaran/pembelian stok).

#### `includes/koneksi.php`

* **`getenv()`**: Mengambil variabel lingkungan (*environment variables*) server seperti `PGHOST`, `PGPORT`, `PGDATABASE`, `PGUSER`, dan `PGPASSWORD`. Jika tidak diset, sistem memakai kredensial lokal bawaan (`127.0.0.1:5432`).
* **`PDO` (PHP Data Objects)**: Menghubungkan PHP ke PostgreSQL.
* **Mode Error PDO**: Memakai `PDO::ERRMODE_EXCEPTION` agar query yang gagal dapat ditangkap oleh blok `try-catch`.

---

### 2. File Template UI Layout

#### `includes/header.php`

* Menjalankan `session_start()` di baris paling atas agar pesan *flash session* dapat terbaca di seluruh halaman.
* Memanggil pustaka Bootstrap 5, FontAwesome, dan menghubungkan stylesheet eksternal `/Jobsheet8/assets/css/style.css`.
* Menampilkan *navigation bar* utama untuk navigasi Beranda, Barang, dan Pelanggan.

#### `includes/footer.php`

* Menutup tag HTML, menampilkan hak cipta, serta memuat file JavaScript Bootstrap dan script opsional (`$extra_scripts`).

#### `assets/css/style.css`

* Menyoroti tema *Warm Chocolate* dengan CSS Variables (`:root`) untuk mempermudah pengaturan skema warna utama (`--primary-color`, `--dark-chocolate`, `--bg-cream`).

---

### 3. Halaman Utama / Dashboard (`index.php`)

* **Query Agregasi Data**:
* `COUNT(*)` digunakan untuk menghitung total barang dan pelanggan.
* `SUM(nominal)` dipadukan dengan `date_trunc('month', tanggal) = date_trunc('month', CURRENT_DATE)` untuk menghitung total kas masuk/keluar khusus bulan berjalan di PostgreSQL.


* **Logika Stok Kritis**: Mengambil 5 barang dengan stok $\le 5$ (`SELECT nama, stok FROM barang WHERE stok <= 5 ORDER BY stok ASC LIMIT 5`) untuk ditampilkan pada widget peringatan.
* **Riwayat Transaksi**: Mengambil 5 transaksi kas terakhir untuk ringkasan arus kas cepat.

---

### 4. Modul Barang (`barang/`)

#### `barang/list.php`

* Menjalankan query `SELECT * FROM barang ORDER BY id DESC` untuk menampilkan daftar inventaris barang.
* Menggunakan pengkondisian PHP untuk warna badge stok (Merah = Habis, Kuning = Kritis $\le 5$, Hijau = Aman).
* Memeriksa dan menampilkan pesan notifikasi dari sesi (`$_SESSION['flash']`), lalu menghapusnya dengan `unset()`.

#### `barang/tambah.php` & `barang/proses_tambah.php`

* **`tambah.php`**: Menyediakan form input nama barang, produsen, tanggal masuk, kode/barcode, harga, stok awal, dan kategori.
* **`proses_tambah.php`**:
* Validasi input wajib dan pemeriksaan nilai angka (`harga`, `stok`) $\ge 0$.
* Menggunakan **Database Transaction** (`beginTransaction()`, `commit()`, `rollBack()`):
1. Menyimpan barang baru ke tabel `barang`.
2. Jika stok awal > 0, sistem otomatis menghitung total pengeluaran ($\text{harga} \times \text{stok}$) dan memasukkan catatan kas keluar (`jenis = 'keluar'`) ke tabel `transaksi`.





#### `barang/proses_keluar.php`

* Digunakan untuk mencatat barang keluar. Memeriksa kecukupan stok, mengurangi jumlah stok barang, lalu mencatat arus kas masuk (`jenis = 'masuk'`) ke tabel `transaksi`.

#### `barang/hapus.php`

* Menerima parameter `id` melalui `$_GET['id']`.
* Dalam transaksi PDO, menghapus riwayat transaksi terkait di tabel `transaksi` berdasarkan nama barang, lalu menghapus data barang dari tabel `barang`.

---

### 5. Modul Pelanggan (`pelanggan/`)

#### `pelanggan/list.php`

* Menampilkan tabel pelanggan dan menyediakan tombol **"+ Beli Barang"** yang memicu *Bootstrap Modal*.
* Modal berisi dropdown barang yang stoknya tersedia (`stok > 0`).

#### `pelanggan/proses_beli.php`

* **`SELECT ... FOR UPDATE`**: Mengunci baris data barang di database selama transaksi berjalan untuk mencegah *race condition* (pembelian bersamaan yang melebihi stok tersisa).
* Mengurangi stok barang di tabel `barang`.
* Mencatat transaksi kas masuk (`jenis = 'masuk'`) pada tabel `transaksi` dengan keterangan `"Penjualan ke [Nama Pelanggan]: [Nama Barang] ([Jumlah] pcs)"`.

#### `pelanggan/tambah.php` & `pelanggan/proses_tambah.php`

* Form dan handler backend untuk mendaftarkan pelanggan baru (`nama`, `no_pelanggan`, `alamat`, `no_hp`).

#### `pelanggan/hapus.php`

* Menghapus pelanggan berdasarkan ID dan menghapus riwayat transaksi penjualan yang terikat dengan pelanggan tersebut.

---

### 6. File JavaScript (`assets/js/`)

* **`app.js`**:
* `initTableFilter()`: Pencarian real-time pada tabel tanpa reload halaman.
* `initValidasiForm()`: Validasi awal di sisi klien (*client-side*).


* **`buku.js` & `anggota.js**`: Menyediakan fungsi muat ulang data tabel.

---

## Penjelasan Kode

Berikut adalah penjelasan mendalam untuk baris dan blok sintaks kode utama di setiap file PHP proyek Anda, agar Anda dapat memahami fungsi teknis setiap sintaksnya secara detail:

---

### 1. `includes/koneksi.php` (Koneksi Database PDO)

```php
$host     = getenv('PGHOST') ?: '127.0.0.1';

```

* **`getenv('PGHOST')`**: Mengambil nilai variabel lingkungan (*environment variable*) bernama `PGHOST` dari server hosting (seperti Neon/Vercel/Heroku).


* **`?: '127.0.0.1'`**: Operator *Elvis* (shorthand ternary). Jika `getenv()` mengembalikan nilai `false` atau kosong, maka variabel `$host` akan diisi secara otomatis dengan IP lokal `'127.0.0.1'`.



```php
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

```

* **`$dsn` (Data Source Name)**: String format khusus yang memberitahu driver database jenis database yang digunakan (`pgsql`), alamat host, port, dan nama database yang ingin dibuka.



```php
$pdo = new PDO($dsn, $user, $password, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

```

* **`new PDO(...)`**: Membuat instansiasi objek koneksi database PDO baru.


* **`PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`**: Mengatur mode penanganan error agar setiap ada kesalahan query SQL, PHP langsung melemparkan `PDOException` yang bisa ditangkap oleh blok `catch`.


* **`PDO::FETCH_ASSOC`**: Mengatur agar hasil query database yang diambil selalu berbentuk array asosiatif dengan nama kolom sebagai *key*-nya.



---

### 2. `includes/header.php` (Header & Navigasi)

```php
session_start();

```

* **`session_start()`**: Memulai atau melanjutkan sesi pengguna. Sangat wajib dipanggil sebelum ada output HTML agar variabel global `$_SESSION` bisa diakses untuk fitur notifikasi/flash message.



```php
<title><?= isset($page_title) ? htmlspecialchars($page_title) . ' - Toko Madura' : 'Toko Madura' ?></title>

```

* **`<?= ... ?>`**: Short-echo tag PHP untuk mencetak string secara langsung.
* **`isset($page_title)`**: Memeriksa apakah variabel `$page_title` sudah didefinisikan di file utama.


* **`htmlspecialchars(...)`**: Mencegah serangan XSS (Cross-Site Scripting) dengan mengonversi karakter khusus HTML (seperti `<` atau `>`) menjadi karakter entitas aman.

---

### 3. `index.php` (Dashboard & Agregasi SQL)

```php
$stmtBarang = $pdo->query("SELECT COUNT(*) AS total FROM barang");
$totalBarang = $stmtBarang->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

```

* **`$pdo->query(...)`**: Menjalankan instruksi SQL langsung ke database.


* **`COUNT(*) AS total`**: Agregat SQL untuk menghitung seluruh jumlah baris data pada tabel `barang`.


* **`->fetch(...)`**: Mengambil satu baris hasil query.


* **`?? 0`**: Operator *Null Coalescing*. Jika nilai kueri mengembalikan `null`, variabel `$totalBarang` diisi angka `0`.

```php
SELECT COALESCE(SUM(nominal), 0) AS total 
FROM transaksi 
WHERE jenis = 'masuk' 
  AND date_trunc('month', tanggal) = date_trunc('month', CURRENT_DATE)

```

* **`COALESCE(SUM(nominal), 0)`**: Menjumlahkan seluruh kolom `nominal`. Jika belum ada transaksi sama sekali (hasilnya `NULL`), fungsi `COALESCE` mengembalikannya sebagai angka `0`.
* **`date_trunc('month', tanggal) = date_trunc('month', CURRENT_DATE)`**: Fungsi khas PostgreSQL untuk memotong komponen tanggal hingga batas bulan. Digunakan untuk menyaring transaksi khusus pada bulan berjalan saja.

---

### 4. `barang/proses_tambah.php` (Tambah Barang & Transaksi Kas)

```php
$nama     = trim($_POST['nama'] ?? '');

```

* **`$_POST['nama']`**: Mengambil data yang dikirim melalui metode HTTP POST dari elemen form bertag `name="nama"`.


* **`trim(...)`**: Menghapus spasi kosong yang tidak sengaja terketik di awal dan akhir teks.



```php
$pdo->beginTransaction();

```

* **`$pdo->beginTransaction()`**: Memulai transaksi database. Semua perintah `INSERT`, `UPDATE`, atau `DELETE` setelah perintah ini bersifat sementara dan belum permanen sampai dijalankan fungsi `commit()`.



```php
$stmt = $pdo->prepare(
    "INSERT INTO barang (nama, produsen, tahun, kode, harga, stok, kategori)
     VALUES (:nama, :produsen, :tahun, :kode, :harga, :stok, :kategori)
     RETURNING id"
);
$stmt->execute([
    'nama'     => $nama,
    'produsen' => $produsen,
    ...
]);

```

* **`$pdo->prepare(...)`**: Menyiapkan *Prepared Statement*. Memisahkan sintaks SQL dari data input menggunakan *placeholder* (seperti `:nama`) untuk mencegah serangan **SQL Injection**.


* **`RETURNING id`**: Fitur PostgreSQL yang mengembalikan ID baris barang yang baru saja selesai di-*insert*.
* **`$stmt->execute([...])`**: Menjalankan query SQL dengan memasukkan array data asli ke dalam *placeholder* secara aman.



```php
$pdo->commit();

```

* **`$pdo->commit()`**: Menyimpan seluruh perubahan secara permanen ke database jika semua perintah query di dalam blok `try` berjalan tanpa eror.



```php
catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menyimpan data: ' . $e->getMessage()];
}

```

* **`$pdo->rollBack()`**: Membatalkan seluruh perintah SQL yang sempat dieksekusi di dalam blok `try` jika terjadi kesalahan di salah satu langkahnya (menjaga konsistensi data).


* **`$_SESSION['flash']`**: Menyimpan pesan notifikasi eror ke dalam sesi.



```php
header('Location: list.php');
exit;

```

* **`header('Location: list.php')`**: Mengarahkan (*redirect*) halaman browser ke `list.php` secara otomatis.


* **`exit`**: Menghentikan eksekusi skrip PHP di bawahnya secara total agar skrip tidak terus berjalan saat proses *redirection*.



---

### 5. `pelanggan/proses_beli.php` (Transaksi Beli & Row Locking)

```php
$stmtB = $pdo->prepare("SELECT * FROM barang WHERE id = :id FOR UPDATE");

```

* **`FOR UPDATE`**: Perintah *Row Locking* tingkat database. Perintah ini mengunci baris data barang yang sedang dipilih agar pengguna lain tidak bisa mengubah stok barang tersebut secara bersamaan sampai transaksi selesai, berguna mencegah fenomena **Race Condition** (penjualan ganda pada stok terakhir).



```php
if ($barang['stok'] < $jumlahBeli) {
    throw new Exception("Stok barang '" . $barang['nama'] . "' tidak mencukupi!");
}

```

* **`throw new Exception(...)`**: Memaksa sistem melemparkan eksepsi secara manual jika kondisi stok barang yang ada di database kurang dari jumlah permintaan pembeli. Eksepsi ini otomatis melompat ke blok `catch` untuk menjalankan `$pdo->rollBack()`.



---

### 6. `barang/list.php` (Flash Notification Reset)

```php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

```

* **`$_SESSION['flash'] ?? null`**: Mengambil array notifikasi dari sesi jika ada.


* **`unset($_SESSION['flash'])`**: Menghapus variabel `flash` dari dalam sesi secara langsung setelah diambil. Tujuannya agar notifikasi hanya muncul 1 kali saat halaman di-*load* pertama kali dan hilang saat halaman di-*refresh*.


## Panduan Instalasi

1. **Clone / Salin Folder Proyek**:
Letakkan folder proyek pada direktori server Anda (misal `htdocs/Jobsheet8`).
2. **Import Database**:
Jalankan query yang terdapat pada file `barang_pelanggan_transaksi.sql` di PostgreSQL.
3. **Jalankan Aplikasi**:
Akses via browser di: `http://localhost/Jobsheet8/index.php` atau gunakan PHP Built-in Server:
```bash
php -S localhost:8000

```
