---

## 📌 DAFTAR ISI
1. [Gambaran Umum](#1-gambaran-umum)
2. [Struktur Direktori](#2-struktur-direktori)
3. [Wireframe Setiap Jobsheet](#3-wireframe-setiap-jobsheet)
4. [Panduan Penggunaan](#4-panduan-penggunaan)
5. [Cara Kerja `api/` dan `vercel.json`](#5-cara-kerja-api-dan-verceljson)
6. [Penjelasan Detail Cara Kerja Kode](#6-penjelasan-detail-cara-kerja-kode)
   - [A. Konfigurasi Variabel CSS & Tema](#a-konfigurasi-variabel-css--tema)
   - [B. Kartu Modul Aktif (Jobsheet 1 – 8)](#b-kartu-modul-aktif-jobsheet-1--8)
   - [C. Kartu Modul Terkunci/Disabled (Jobsheet 9 – 13)](#c-kartu-modul-terkuncidisabled-jobsheet-9--13)
7. [Konsep Pemrograman & UI/UX yang Dipelajari](#7-konsep-pemrograman--uiux-yang-dipelajari)

---

## 1. GAMBARAN UMUM

File `index.html` ini berfungsi sebagai **pintu masuk utama (Hub Navigasi)** untuk mengakses seluruh modul praktikum *Jobsheet* yang terdapat pada repositori. 

### **Fitur Utama:**
* **Responsive Grid System**: Menggunakan Bootstrap 5 untuk memastikan tampilan optimal di layar *mobile*, tablet, maupun desktop.
* **Warm Theme Aesthetic**: Mengusung skema warna *Warm Chocolate & Cream* yang konsisten dengan identitas aplikasi SIMPUS Toko Kelontong.
* **Direct Folder Routing**: Tautan ke folder Jobsheet menggunakan path relatif.
* **Visual Locking Effect**: Kartu Jobsheet dapat diberi penanda visual sesuai status yang didefinisikan pada halaman utama.
* **Dokumentasi wireframe**: Setiap Jobsheet memiliki sketsa halaman/alur tersendiri di `docs/wireframe.md`.

---

## 2. STRUKTUR DIREKTORI

```
├── api/
│   └── index.php            <-- Front controller PHP untuk routing deployment Vercel
├── index.html              <-- File Landing Page Navigasi Utama
├── README.md               <-- Panduan & Dokumentasi
├── handbook.html           <-- Handbook penjelasan kode Jobsheet 1–12
├── Jobsheet1/ ... Jobsheet12/
│   └── docs/wireframe.md    <-- Wireframe khusus untuk Jobsheet tersebut
└── vercel.json             <-- Runtime PHP dan aturan routing deployment Vercel
```

Folder `Jobsheet1`–`Jobsheet7` berisi tahapan SIMPUS (perpustakaan mini); `Jobsheet8`–`Jobsheet12` berisi perkembangan aplikasi inventaris dan penjualan Toko Madura. Setiap folder Jobsheet juga memiliki README masing-masing dengan uraian modulnya.

## 3. WIREFRAME SETIAP JOBSHEET

Wireframe berikut adalah sketsa teks untuk memahami susunan halaman dan alur utamanya sebelum membaca HTML/PHP. Buka berkas tiap Jobsheet untuk melihat rancangan lebih lengkap:

| Jobsheet | Wireframe |
| --- | --- |
| 1 — Struktur HTML SIMPUS | [Jobsheet1/docs/wireframe.md](Jobsheet1/docs/wireframe.md) |
| 2 — CSS terpisah | [Jobsheet2/docs/wireframe.md](Jobsheet2/docs/wireframe.md) |
| 3 — Bootstrap dan CSS kustom | [Jobsheet3/docs/wireframe.md](Jobsheet3/docs/wireframe.md) |
| 4 — Konsistensi halaman SIMPUS | [Jobsheet4/docs/wireframe.md](Jobsheet4/docs/wireframe.md) |
| 5 — Bootstrap dan JavaScript | [Jobsheet5/docs/wireframe.md](Jobsheet5/docs/wireframe.md) |
| 6 — Data JSON dan `fetch()` | [Jobsheet6/docs/wireframe.md](Jobsheet6/docs/wireframe.md) |
| 7 — PHP dan session | [Jobsheet7/docs/wireframe.md](Jobsheet7/docs/wireframe.md) |
| 8 — Inventaris dan penjualan | [Jobsheet8/docs/wireframe.md](Jobsheet8/docs/wireframe.md) |
| 9 — CRUD barang dan pelanggan | [Jobsheet9/docs/wireframe.md](Jobsheet9/docs/wireframe.md) |
| 10 — Autentikasi | [Jobsheet10/docs/wireframe.md](Jobsheet10/docs/wireframe.md) |
| 11 — Output aman dan CSRF | [Jobsheet11/docs/wireframe.md](Jobsheet11/docs/wireframe.md) |
| 12 — Transaksi relasional | [Jobsheet12/docs/wireframe.md](Jobsheet12/docs/wireframe.md) |

## 4. PANDUAN PENGGUNAAN

### **A. Pengujian Lokal (Local Development)**

1. Jalankan web server lokal seperti **Laragon** atau **XAMPP**.
2. Buka browser dan akses alamat domain lokal, misalnya `http://dpw.test/` atau `http://localhost/dpw/`.
3. Mengklik kartu Jobsheet 1 hingga 8 akan langsung mengarahkan browser ke halaman `index.php` atau `index.html` di dalam folder masing-masing modul.

### **B. Penerbitan ke Vercel (Production)**

1. Hubungkan repositori ke proyek Vercel dan pastikan root proyek yang dipilih berisi `vercel.json`, `api/`, halaman utama, dan folder Jobsheet.
2. Atur environment variable yang dibutuhkan aplikasi PHP/database pada pengaturan proyek Vercel. Nilai lokal pada berkas koneksi PHP bukan pengganti konfigurasi deployment yang aman.
3. Deploy repositori, kemudian uji URL beranda dan URL halaman Jobsheet. Konfigurasi saat ini meneruskan sebagian besar request ke front controller `api/index.php`; lihat penjelasan rute berikut.

## 5. CARA KERJA `api/` DAN `vercel.json`

### `api/index.php`: front controller, bukan kumpulan endpoint API

Folder `api/` root saat ini hanya berisi `index.php`. File ini bertindak sebagai **front controller/router** untuk konfigurasi Vercel. Ia membaca path request, mencari file atau folder yang diminta di root repositori, dan:

- jika path menunjuk folder, mencoba `index.html`, lalu `index.php`;
- menyajikan file `.html`, `.css`, dan `.js` dengan content type yang sesuai;
- mengeksekusi file `.php` menggunakan `require`;
- mengirim status HTTP 404 jika target tidak ditemukan atau ekstensinya tidak ditangani.

Jadi, `api/index.php` bukan API bisnis khusus seperti `/api/users` yang mengembalikan JSON. Ia menerima berbagai URL situs dan meneruskannya ke file proyek yang cocok, termasuk halaman Jobsheet. Routing ini membuat satu fungsi PHP menangani jalur halaman yang berbeda.

### `vercel.json`: runtime dan urutan routing

```json
{
  "functions": {
    "api/index.php": { "runtime": "vercel-php@0.9.0" }
  },
  "routes": [
    { "src": "/(assets/.*)", "dest": "/$1" },
    { "src": "/(.*)", "dest": "/api/index.php" }
  ]
}
```

- **`functions`** menetapkan runtime PHP `vercel-php@0.9.0` untuk fungsi `api/index.php`, sehingga Vercel dapat menjalankan router tersebut sebagai fungsi backend.
- **Rute pertama** mencocokkan URL yang dimulai dengan `/assets/` dan mengarahkannya ke file asset pada path tersebut agar file aset root dapat dilayani langsung.
- **Rute kedua** adalah fallback: semua URL lain diteruskan ke `/api/index.php`. Router kemudian memilih berkas HTML/PHP/CSS/JS dari path request.
- `dest` pada aturan `routes` adalah tujuan pemrosesan di sisi deployment; aturan tersebut bukan tautan HTML ke README maupun contoh route khusus seperti `/Jobsheet8` ke `api/Jobsheet8.php`. URL browser pada umumnya tetap memakai URL yang diminta karena ini routing internal.

Konfigurasi ini **tidak** mendefinisikan CORS, header keamanan, atau environment variable; hal tersebut perlu disetel secara terpisah jika dibutuhkan. Keberhasilan deployment PHP juga bergantung pada dukungan runtime Vercel dan konfigurasi environment variable/database. Untuk pengembangan lokal, Laragon/XAMPP biasanya melayani file secara langsung dan tidak menggunakan front controller Vercel ini.

## 6. PENJELASAN DETAIL CARA KERJA KODE

### **A. Konfigurasi Variabel CSS & Tema**

Di bagian `<style>`, variabel CSS (*Custom Properties*) didefinisikan pada pseudoclass `:root` agar dapat digunakan kembali di seluruh dokumen:

```css
:root {
    --primary-color: #5c3d2e;       /* Warna cokelat mocha untuk elemen utama & badge */
    --primary-hover: #43281c;       /* Warna saat kursor di atas elemen interaktif */
    --dark-chocolate: #2c1d11;      /* Cokelat gelap untuk baris navigasi & judul */
    --bg-cream: #f8f4e9;            /* Background krem yang lembut di mata */
    --border-color: #e6ddc4;        /* Warna garis tepi pembatas kartu */
}

```

* **Manfaat Belajar**: Penggunaan `:root` memudahkan *maintenance* warna. Jika di kemudian hari tema ingin diubah, cukup edit variabel di `:root` tanpa perlu mengubah baris CSS satu per satu.

---

### **B. Kartu Modul Aktif (Jobsheet 1 – 8)**

Modul yang sudah tersedia dibungkus menggunakan tag `<a>` yang diubah perilakunya menjadi blok (`display: block`).

```html
<a href="./Jobsheet1/" class="jobsheet-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="jobsheet-badge">Jobsheet 1</span>
        <small class="text-muted">/Jobsheet1</small>
    </div>
    <h5 class="fw-bold mb-2" style="color: var(--dark-chocolate);">HTML5 Semantic Skeleton</h5>
    <p class="text-secondary small mb-3">Struktur elemen semantik dasar untuk modul web SIMPUS.</p>
    <div class="d-flex align-items-center text-primary fw-semibold small">
        <span>Buka Modul</span> &rarr;
    </div>
</a>

```

#### **CSS Terkait:**

```css
.jobsheet-card {
    background: #ffffff;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    transition: all 0.2s ease-in-out;
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
}

.jobsheet-card:hover {
    transform: translateY(-4px); /* Memberikan efek kartu terangkat naik */
    box-shadow: 0 8px 20px rgba(44, 29, 17, 0.12); /* Bayangan lembut */
    border-color: var(--primary-color);
}

```

* **Manfaat Belajar**:
* Menggunakan atribut `href="./Jobsheet1/"` memanfaatkan *relative path* yang aman digunakan baik di *localhost* maupun server *cloud*.
* Efek `transform: translateY(-4px)` saat `:hover` memberikan umpan balik visual (*micro-interaction*) kepada pengguna bahwa kartu tersebut interaktif.



---

### **C. Kartu Modul Terkunci/Disabled (Jobsheet 9 – 13)**

Untuk modul yang belum siap, kita tidak menggunakan tag `<a>` melainkan `<div>` dengan dua lapisan visual (*layering*).

```html
<div class="jobsheet-card-disabled p-4">
    <!-- Layer 1: Overlay Kunci (Paling Depan) -->
    <div class="locked-overlay">
        <span class="badge-locked">🔒 Segera</span>
        <small class="text-muted mt-1 fw-semibold">Tidak dapat diakses</small>
    </div>
    
    <!-- Layer 2: Konten Latar Belakang (Kabur) -->
    <div class="blur-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="jobsheet-badge">Jobsheet 9</span>
            <small class="text-muted">/Jobsheet9</small>
        </div>
        <h5 class="fw-bold mb-2">CRUD Penuh</h5>
        <p class="text-secondary small mb-3">Pengelolaan data lengkap.</p>
    </div>
</div>

```

#### **CSS Terkait:**

```css
.jobsheet-card-disabled {
    position: relative;
    overflow: hidden;
    cursor: not-allowed;  /* Mengubah kursor mouse menjadi simbol larangan */
    user-select: none;     /* Mencegah teks bisa di-highlight/di-copy */
}

.blur-content {
    filter: blur(3px);      /* Memberi efek buram/kabur pada teks */
    opacity: 0.5;           /* Menurunkan tingkat transparansi */
    pointer-events: none;   /* Mencegah klik atau interaksi kursor */
}

.locked-overlay {
    position: absolute;    /* Menempatkan overlay tepat di atas kartu */
    top: 0; left: 0;
    width: 100%; height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: rgba(248, 244, 233, 0.4); /* Transparansi warna krem */
    z-index: 2;            /* Memastikan posisi selalu di atas layer blur */
}

```

* **Manfaat Belajar**:
* **Positioning CSS (`relative` vs `absolute`)**: `position: relative` pada kontainer induk membuat `position: absolute` pada `.locked-overlay` terkunci di dalam batas area kartu tersebut.
* **Property `pointer-events: none**`: Memastikan elemen tidak merespons klik, sehingga mematikan navigasi secara total.



---

## 7. KONSEP PEMROGRAMAN & UI/UX YANG DIPELAJARI

| Konsep | Penerapan pada Kode | Manfaat UI/UX |
| --- | --- | --- |
| **Semantic HTML5** | Menggunakan `<header>`, `<main>`, `<footer/>`, `<section>` | Membantu mesin pencari (SEO) dan aksesibilitas *screen reader*. |
| **CSS Variables** | `--primary-color`, `--bg-cream` di `:root` | Konsistensi warna pada seluruh elemen desain. |
| **Flexbox & Grid** | `.row`, `.col-12`, `.col-md-6`, `.col-lg-3` | Tata letak responsif yang menyesuaikan ukuran layar perangkat secara otomatis. |
| **Layering & Z-Index** | `.locked-overlay` di atas `.blur-content` | Memberikan konteks visual jelas bahwa fitur sedang terkunci tanpa membingungkan pengguna. |
| **Micro-Interactions** | Transition & CSS Transform `translateY` | Memberikan kesan intuitif dan responsif saat antarmuka disentuh atau disorot kursor. |

---

## Handbook Penjelasan Kode Jobsheet

Untuk penjelasan lebih lengkap tentang cara kerja CSS, JavaScript, dan PHP pada Jobsheet 1–12, buka [Handbook Jobsheet](./handbook.html). Handbook tersebut membahas selector dan cascade CSS, event dan Fetch API JavaScript, serta request PHP, session, PDO, validasi, transaksi database, autentikasi, dan CSRF.

---