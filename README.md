Dokumentasi teknis, panduan penggunaan, dan materi pembelajaran untuk antarmuka navigasi utama (*landing page*) proyek **SIMPUS Toko Kelontong**.

---

## 📌 DAFTAR ISI
1. [Gambaran Umum](#1-gambaran-umum)
2. [Struktur Direktori](#2-struktur-direktori)
3. [Panduan Penggunaan](#3-panduan-penggunaan)
4. [Penjelasan Detail Cara Kerja Kode](#4-penjelasan-detail-cara-kerja-kode)
   - [A. Konfigurasi Variabel CSS & Tema](#a-konfigurasi-variabel-css--tema)
   - [B. Kartu Modul Aktif (Jobsheet 1 – 8)](#b-kartu-modul-aktif-jobsheet-1--8)
   - [C. Kartu Modul Terkunci/Disabled (Jobsheet 9 – 13)](#c-kartu-modul-terkuncidisabled-jobsheet-9--13)
5. [Konsep Pemrograman & UI/UX yang Dipelajari](#5-konsep-pemrograman--uiux-yang-dipelajari)

---

## 1. GAMBARAN UMUM

File `index.html` ini berfungsi sebagai **pintu masuk utama (Hub Navigasi)** untuk mengakses seluruh modul praktikum *Jobsheet* yang terdapat pada repositori. 

### **Fitur Utama:**
* **Responsive Grid System**: Menggunakan Bootstrap 5 untuk memastikan tampilan optimal di layar *mobile*, tablet, maupun desktop.
* **Warm Theme Aesthetic**: Mengusung skema warna *Warm Chocolate & Cream* yang konsisten dengan identitas aplikasi SIMPUS Toko Kelontong.
* **Direct Folder Routing**: Tautan langsung ke sub-folder bersih tanpa spasi (`./Jobsheet1/` hingga `./Jobsheet8/`).
* **Visual Locking Effect**: Efek visual *blur*, *overlay*, dan pointer `not-allowed` untuk menandai modul yang belum dirilis/diakses (Jobsheet 9 – 13).

---

## 2. STRUKTUR DIREKTORI

```
├── index.html              <-- File Landing Page Navigasi Utama
├── README.md               <-- Panduan & Dokumentasi
├── Jobsheet1/              <-- HTML5 Semantic Skeleton
├── Jobsheet2/              <-- CSS3 Styling Dasar
├── Jobsheet3/              <-- Responsive Design dengan Framework
├── Jobsheet4/              <-- UI/UX Design
├── Jobsheet5/              <-- JavaScript DOM & Event
├── Jobsheet6/              <-- Fetch API & JSON
├── Jobsheet7/              <-- PHP Dasar & Form Handling
└── Jobsheet8/              <-- Koneksi PostgreSQL
```


## 3. PANDUAN PENGGUNAAN

### **A. Pengujian Lokal (Local Development)**

1. Jalankan web server lokal seperti **Laragon** atau **XAMPP**.
2. Buka browser dan akses alamat domain lokal, misalnya `http://dpw.test/` atau `http://localhost/dpw/`.
3. Mengklik kartu Jobsheet 1 hingga 8 akan langsung mengarahkan browser ke halaman `index.php` atau `index.html` di dalam folder masing-masing modul.

### **B. Penerbitan ke Vercel (Production)**

1. Simpan file `index.html` di tingkat teratas (*root folder*) repositori Git.
2. *Push* perubahan ke GitHub.
3. Vercel akan otomatis mendeteksi `index.html` sebagai titik mula halaman web (*entry point*) untuk domain `dpw.fafirru.my.id`.

---

## 4. PENJELASAN DETAIL CARA KERJA KODE

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

## 5. KONSEP PEMROGRAMAN & UI/UX YANG DIPELAJARI

| Konsep | Penerapan pada Kode | Manfaat UI/UX |
| --- | --- | --- |
| **Semantic HTML5** | Menggunakan `<header>`, `<main>`, `<footer/>`, `<section>` | Membantu mesin pencari (SEO) dan aksesibilitas *screen reader*. |
| **CSS Variables** | `--primary-color`, `--bg-cream` di `:root` | Konsistensi warna pada seluruh elemen desain. |
| **Flexbox & Grid** | `.row`, `.col-12`, `.col-md-6`, `.col-lg-3` | Tata letak responsif yang menyesuaikan ukuran layar perangkat secara otomatis. |
| **Layering & Z-Index** | `.locked-overlay` di atas `.blur-content` | Memberikan konteks visual jelas bahwa fitur sedang terkunci tanpa membingungkan pengguna. |
| **Micro-Interactions** | Transition & CSS Transform `translateY` | Memberikan kesan intuitif dan responsif saat antarmuka disentuh atau disorot kursor. |

---