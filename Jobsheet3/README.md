# Laporan 

<h4>Nama : Fafirru Hadzami Syach Mashuri<h4>
<h4>NIM : 254107020104<h4>
<h4>Kelas : TI-2D<h4>

## Modifikasi Style CSS (`assets/css/style.css`)

### 1. Penjelasan Perubahan & Modifikasi Kode
Berikut adalah rincian penyesuaian yang diterapkan pada berkas `style.css`:

1. **Penyelarasan Layout Grid Statistik (`main section:nth-of-type(2) h2`)**:
   * Menambahkan `grid-column: 1 / -1;` pada judul section statistik.
   * **Fungsi**: Memaksa elemen `<h2>` (**Ringkasan**) mengambil 1 baris penuh di bagian atas grid, sehingga 3 kartu statistik (`article`) dapat berderet rapi secara horizontal di bawahnya.
2. **Skema Warna & Kontras**:
   * **Body**: `background-color` disesuaikan menjadi `#eef4fa` agar tampilan latar lebih lembut.
   * **Header & Tabel**: Menggunakan warna biru pekat `#164869` untuk latar `header` dan `thead` tabel agar terkesan lebih kokoh.
   * **Tautan (`a`)**: Menggunakan warna `#164869` untuk menyelaraskan dengan aksen warna utama.
3. **Penyelarasan Komponen (Form, Tabel, & Kartu)**:
   * Mengubah `border-radius` pada kartu statistik menjadi `4px` agar konsisten dengan sudut tombol dan input form.
   * Mengubah warna garis pembatas (`border-bottom`) tabel menggunakan `#cdd4da`.
   * Menyesuaikan `padding` dan ketebalan font (`font-weight`) pada label form dan navigasi header.
4. **Pendekatan Responsif Mobile-First**:
   * Mengubah pendekatan penulisan CSS dari *Desktop-First* (`max-width`) menjadi *Mobile-First* (`min-width`).
   * Menyesuaikan breakpoint tablet dari `768px` ke `900px`.
   * Menambahkan breakpoint baru `@media (min-width: 1400px)` untuk memperlebar area `main` menjadi `1300px` pada layar monitor besar.
   * Menerapkan aturan `overflow-x: auto` pada blok kode (`<pre>`) agar tidak meluap keluar layar pada ukuran seluler.

---

### 2. Kode CSS Lengkap (Versi Mobile-First)

```css
/* Reset & Base */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: "Segoe UI", Arial, sans-serif;
    color: #2b2b2b;
    background-color: #f5f6f8;
    line-height: 1.5;
} 

a {
    color: #164869;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Header & Navbar (Mobile Default) */
header {
    background-color: #164869;
    color: #fff;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    position: relative;
}

header h1 {
    font-size: 1.8rem;
}

/* Hamburger Menu (Mobile Default) */
.nav-toggle {
    display: none;
}

.nav-toggle-label {
    display: block;
    font-size: 1.6rem;
    color: #fff;
    cursor: pointer;
}

header nav {
    display: none;
    width: 100%;
    order: 3;
    margin-top: 1rem;
}

.nav-toggle:checked ~ nav {
    display: block;
}

header nav ul,
header nav ol {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

header nav a {
    color: #fff;
    font-weight: 600;
}

/* Main Layout */
main {
    max-width: 100%;
    margin: 1.5rem auto;
    padding: 0 1rem;
}
    
section {
    background-color: #fff;
    border-radius: 8px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

section h2 {
    margin-bottom: 1rem;
    color: #1d5b8a;
}

/* Kartu Statistik (1 Kolom di Mobile) */
main section:nth-of-type(2) {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
}

main section:nth-of-type(2) h2 {
    grid-column: 1 / -1;
}

main section:nth-of-type(2) article {
    background-color: #f7f9fb;
    border-radius: 4px;
    padding: 1.5rem;
    text-align: center;
}

main section:nth-of-type(2) article h3 {
    font-size: 0.95rem;
    color: #444;
    margin-bottom: 0.35rem;
}

main section:nth-of-type(2) article p {
    font-size: 1.8rem;
    font-weight: 700;
    color: #164869;
}

/* Tabel & Code Responsif */
.table-responsive, pre {
    overflow-x: auto;
    max-width: 100%;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    text-align: left;
    padding: 0.75rem;
    border-bottom: 1px solid #cdd4da;
}

thead {
    background-color: #164869;
    color: #fff;
}

tbody tr:nth-child(even) {
    background-color: #f5f6f8;
}

tbody tr:hover {
    background-color: #eef4fa;
}

td button {
    padding: 0.35rem 0.7rem;
    margin-right: 0.35rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.85rem;
}

td button:first-of-type {
    background-color: #f0ad4e;
    color: #fff;
}

td button:last-of-type {
    background-color: #d9534f;
    color: #fff;
}

/* Form (Full Width di Mobile) */
form p {
    margin-bottom: 1rem;
}

form label {
    display: block;
    margin-bottom: 0.35rem;
    font-weight: 500;
    color: #2b2b2b;
}

form input,
form select {
    width: 100%;
    max-width: 100%;
    padding: 0.6rem 0.75rem;
    border: 1px solid #e2e6ea;
    border-radius: 4px;
    font-size: 1rem;
}

form button[type="submit"] {
    background-color: #1d5b8a;
    color: #fff;
    border: none;
    padding: 0.65rem 1.5rem;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
}

form button[type="submit"]:hover {
    background-color: #164869;
}

/* Footer  */
footer {
    text-align: center;
    padding: 1.5rem;
    color: #55677a;
    font-size: 0.85rem;
}

/* PROGRESSIVE ENHANCEMENT (Min-Width Media Queries) */

/* Tablet (Lebar >= 481px hingga 900px) */
@media (min-width: 481px) {
    main section:nth-of-type(2) {
        grid-template-columns: repeat(2, 1fr);
    }

    form input,
    form select {
        max-width: 400px;
    }
}

/* Desktop (Lebar >= 901px) */
@media (min-width: 901px) {
    .nav-toggle-label {
        display: none;
    }

    header nav {
        display: block;
        width: auto;
        order: initial;
        margin-top: 0;
    }

    header nav ul,
    header nav ol {
        flex-direction: row;
        gap: 1rem;
    }

    main {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    main section:nth-of-type(2) {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Large Desktop (Lebar >= 1400px) */
@media (min-width: 1400px) {
    main {
        max-width: 1300px;
    }
}