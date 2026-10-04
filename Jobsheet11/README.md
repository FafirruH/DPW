
---

# Manajemen Toko Madura — Keamanan Web Dasar (Jobsheet 11)

Sistem Informasi Manajemen Toko Madura berbasis web yang dibangun menggunakan **PHP Native (PDO)** dan database **PostgreSQL**. Pada Jobsheet 11, aplikasi ini mendapatkan audit dan pembaruan keamanan secara menyeluruh untuk menutup celah kerentanan web modern, termasuk perlindungan terhadap **XSS (Cross-Site Scripting)**, **CSRF (Cross-Site Request Forgery)**, dan **Session Fixation**, serta memvalidasi kembali keamanan terhadap **SQL Injection**.

---

## 📋 Daftar Isi

1. [Fitur Utama & Pembaruan Keamanan](https://www.google.com/search?q=%231-fitur-utama--pembaruan-keamanan)
2. [Struktur Proyek](https://www.google.com/search?q=%232-struktur-proyek)
3. [Konsep Dasar Kerentanan Web](https://www.google.com/search?q=%233-konsep-dasar-kerentanan-web)
4. [Implementasi Sistem Keamanan (Mendalam)](https://www.google.com/search?q=%234-implementasi-sistem-keamanan-mendalam)
* [4.1 Pencegahan XSS (Fungsi `e()`)](https://www.google.com/search?q=%2341-pencegahan-xss-fungsi-e)
* [4.2 Proteksi CSRF (Token Per-Sesi)](https://www.google.com/search?q=%2342-proteksi-csrf-token-per-sesi)
* [4.3 Pencegahan Session Fixation](https://www.google.com/search?q=%2343-pencegahan-session-fixation)
* [4.4 Migrasi Aksi Hapus (GET ke POST)](https://www.google.com/search?q=%2344-migrasi-aksi-hapus-get-ke-post)


5. [Urutan Eksekusi Keamanan (Guard Clauses)](https://www.google.com/search?q=%235-urutan-eksekusi-keamanan-guard-clauses)
6. [Panduan Instalasi & Skenario Pengujian](https://www.google.com/search?q=%236-panduan-instalasi--skenario-pengujian)

---

## 1. Fitur Utama & Pembaruan Keamanan

* **Sanitasi Output (XSS Protection)**: Seluruh output data yang berasal dari database maupun input pengguna kini dibungkus menggunakan fungsi *helper* `e()` yang memanfaatkan `htmlspecialchars()` dengan parameter `ENT_QUOTES`.
* **Verifikasi Token CSRF**: Setiap form yang memodifikasi data (Tambah, Edit, Hapus, Beli, Login, Register) kini dilindungi oleh Token CSRF yang di-generate secara acak menggunakan `random_bytes()` dan divalidasi via `hash_equals()`.
* **Regenerasi ID Sesi**: Sistem secara otomatis mengganti Session ID saat petugas berhasil melakukan *login* untuk mencegah serangan pembajakan sesi (Session Fixation).
* **Pengamanan Tombol Aksi**: Seluruh aksi yang bersifat merusak/menghapus data (seperti `hapus.php`) telah diubah dari *method* `GET` (via tag `<a>`) menjadi *method* `POST` (via tag `<form>`) yang tersembunyi dan ber-token.
* **SQL Injection Audit**: Tetap aman dengan penggunaan metode *Prepared Statements* (`:parameter`) dari ekstensi PDO.

---

## 2. Struktur Proyek

Penambahan dan modifikasi utama difokuskan pada direktori `includes/` dan semua berkas yang memproses form.

```text
Jobsheet11/
├── includes/
│   ├── helpers.php              # BARU: Berisi fungsi e() untuk mencegah XSS
│   ├── csrf.php                 # BARU: Berisi fungsi csrf_token(), csrf_field(), dan csrf_verify()
│   ├── auth.php                 # Guard clause untuk mengecek sesi login pengguna
│   ├── header.php               # Memuat helper.php & csrf.php secara global ke antarmuka
│   └── koneksi.php              # Koneksi PDO ke PostgreSQL
├── auth/
│   ├── login.php                # + Sisipan csrf_field() di dalam form
│   ├── proses_login.php         # + csrf_verify() & session_regenerate_id(true)
│   ├── register.php             # + Sisipan csrf_field() di dalam form
│   └── proses_register.php      # + csrf_verify()
├── barang/ & pelanggan/
│   ├── list.php                 # Output tabel dibungkus e(), tombol hapus diubah jadi <form> POST
│   ├── tambah.php & edit.php    # + Sisipan csrf_field() di dalam form, atribut value="" dibungkus e()
│   ├── hapus.php                # + Pengecekan REQUEST_METHOD === 'POST' dan csrf_verify()
│   └── proses_*.php             # + Pemanggilan csrf_verify() sebelum query dieksekusi
├── index.php                    # Dashboard: output data teks dibungkus e()
└── README.md                    # Dokumentasi ini

```

---

## 3. Konsep Dasar Kerentanan Web

| Kerentanan | Pertanyaan Inti | Penanganan di Proyek Ini |
| --- | --- | --- |
| **XSS (Cross-Site Scripting)** | Bisakah pengguna memasukkan skrip HTML/JS yang akan tereksekusi di browser pengguna lain? | Diblokir menggunakan fungsi `e()` untuk mengubah tag HTML menjadi entitas teks mati. |
| **CSRF (Cross-Site Request Forgery)** | Bisakah situs pihak ketiga memicu aksi (seperti Hapus) atas nama pengguna yang sedang login? | Diblokir menggunakan **Token CSRF** sekali pakai per sesi yang harus dikirim via POST. |
| **Session Fixation** | Bisakah penyerang mencuri atau memaksakan ID sesi sebelum pengguna login? | Ditangani dengan pemanggilan `session_regenerate_id(true)` sesaat setelah password valid. |
| **SQL Injection** | Bisakah pengguna menyisipkan perintah SQL liar lewat input form? | Sudah aman sejak awal menggunakan **PDO Prepared Statements**. |

---

## 4. Implementasi Sistem Keamanan (Mendalam)

### 4.1 Pencegahan XSS (Fungsi `e()`)

Fungsi `e($value)` dibuat di dalam `includes/helpers.php` untuk memfasilitasi sanitasi data secara ringkas:

```php
function e($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

```

Fungsi ini digunakan secara ekstensif pada atribut `value="..."` di dalam form edit dan pada pencetakan data di tag `<td>` tabel. Flag `ENT_QUOTES` memastikan tanda kutip ganda dan tunggal ikut di-*escape*, mencegah penyerang "memutus" atribut HTML.

### 4.2 Proteksi CSRF (Token Per-Sesi)

Diatur melalui `includes/csrf.php`. Sistem kerjanya meliputi 3 tahap:

1. **Pembuatan Token**: `random_bytes(32)` menghasilkan 32-byte string acak yang disimpan di `$_SESSION['csrf_token']`.
2. **Penyisipan Form**: Fungsi `csrf_field()` dipanggil di dalam form untuk mencetak `<input type="hidden" name="csrf_token" value="...">`.
3. **Verifikasi**: File pemroses PHP (`proses_*.php`) akan memanggil `csrf_verify()`. Pembandingan token tidak menggunakan operator `===`, melainkan fungsi kriptografis `hash_equals()` untuk mencegah *Timing Attack*.

### 4.3 Pencegahan Session Fixation

Terdapat perbaikan satu baris yang krusial pada `auth/proses_login.php`:

```php
if ($user && password_verify($password, $user['password'])) {
    unset($_SESSION['login_attempts'][$username]);
    
    // Regenerasi sesi untuk mencegah pembajakan ID
    session_regenerate_id(true); 
    // ...

```

Fungsi ini mengganti ID Sesi lama dengan yang baru tepat sebelum variabel penting (seperti `user_id` dan `role`) dimasukkan ke dalam sesi server.

### 4.4 Migrasi Aksi Hapus (GET ke POST)

Menghapus data via URL (`hapus.php?id=1`) sangat rentan terhadap CSRF. Oleh karena itu, tombol hapus pada tabel direstrukturisasi menjadi *inline form*:

```html
<form action="hapus.php" method="POST" class="d-inline">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <button type="submit">Hapus</button>
</form>

```

File `hapus.php` kini secara eksplisit menolak akses jika `$_SERVER['REQUEST_METHOD'] !== 'POST'`.

---

## 5. Urutan Eksekusi Keamanan (Guard Clauses)

Pada setiap file yang bertugas memproses data (`proses_tambah.php`, `proses_edit.php`, `proses_beli.php`, `hapus.php`), urutan pemanggilan file *include* diatur secara ketat:

```php
require __DIR__ . '/../includes/auth.php';  // 1. Verifikasi apakah pengguna sudah Login
require __DIR__ . '/../includes/csrf.php';  // 2. Muat library CSRF
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();                              // 3. Verifikasi Token CSRF

```

**Mengapa demikian?**
Guard `auth.php` harus dijalankan **sebelum** `csrf_verify()`. Hal ini memastikan bahwa pengunjung yang belum melakukan *login* akan langsung dialihkan ke halaman otentikasi tanpa membuang sumber daya server untuk memvalidasi token CSRF-nya.

---

## 6. Panduan Instalasi & Skenario Pengujian

Untuk memastikan bahwa sistem keamanan telah berjalan semestinya, Anda dapat melakukan 3 pengujian berikut setelah aplikasi dijalankan (misal menggunakan `php -S localhost:8000`):

1. **Pengujian XSS (Cross-Site Scripting)**
* Buka form **Tambah Pelanggan**.
* Masukkan *payload* berbahaya pada kolom Nama Pelanggan: `<script>alert('Diretas!')</script>`.
* Simpan data.
* **Ekspektasi:** Saat Anda melihat halaman Daftar Pelanggan, browser **TIDAK** memunculkan kotak *pop-up* peringatan. Teks tersebut harus tampil murni sebagai tulisan mati berkat fungsi `e()`.


2. **Pengujian CSRF (Cross-Site Request Forgery)**
* Login sebagai Admin, lalu buka form **Edit Barang**.
* Buka *Developer Tools* browser (Klik Kanan -> *Inspect Element*).
* Cari elemen `<input type="hidden" name="csrf_token" value="...">` dan hapus elemen tersebut (*Delete node*).
* Klik tombol **Simpan Perubahan**.
* **Ekspektasi:** Anda akan mendapatkan respon HTTP 403 Forbidden dengan pesan `"Permintaan ditolak: token CSRF tidak valid atau kedaluwarsa"`. Data di database tetap aman dan tidak berubah.


3. **Pengujian Guard Clause**
* Pastikan Anda sedang dalam keadaan **Logout**.
* Buka tab baru dan coba akses URL proses secara langsung: `http://localhost:8000/barang/proses_tambah.php`.
* **Ekspektasi:** Anda tidak akan melihat *error* CSRF atau *error* Database, melainkan langsung ditendang (di-*redirect*) ke halaman `login.php`. Guard `auth.php` berhasil melindungi halaman pemrosesan dengan sempurna.