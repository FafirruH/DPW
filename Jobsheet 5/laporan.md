# Laporan 

<h4>Nama : Fafirru Hadzami Syach Mashuri<h4>
<h4>NIM : 254107020104<h4>
<h4>Kelas : TI-2D<h4>

## Modifikasi Style CSS (`assets/css/style.css`) & Interaktivitas JavaScript (`assets/js/app.js`)

### 1. Penjelasan Perubahan & Modifikasi Kode
Berikut rincian penyesuaian yang diterapkan pada berkas `style.css` dan `app.js`:

1. **Struktur Layout & Sticky Footer**:
   * Menerapkan Flexbox pada elemen `body` (`display: flex; flex-direction: column; min-height: 100vh;`) dan `main.container` (`flex: 1 0 auto;`).
   * **Fungsi**: Memastikan footer selalu berada di bagian paling bawah layar (*sticky footer*) secara konsisten.
2. **Skema Warna & Tema Aplikasi**:
   * Menggunakan class utilitas `.bg-theme`, `.text-theme`, dan `.btn-theme` dengan basis warna `#1d5b8a` serta latar belakang body `#f8fafc`.
   * **Fungsi**: Menyelaraskan komponen visual seperti tombol, latar header/theme, dan teks agar memiliki warna yang konsisten di seluruh halaman.
3. **Hamburger Menu Responsive**:
   * Pengaturan `.nav-toggle-label` pada CSS yang tampil pada layar di bawah `991.88px` dipadukan dengan fungsi `initNavToggle()` di JavaScript.
   * **Fungsi**: Mengontrol buka-tutup menu navigasi *mobile* saat tombol toggle diklik melalui penambahan/penghapusan class `nav-open`.
4. **Pencarian Real-Time & Konfirmasi Hapus Data**:
   * Menerapkan fungsi `initTableFilter()` untuk pencarian data langsung berdasarkan masukan pada `#search-input` dan fungsi `initHapusConfirm()` pada tombol `.btn-hapus`.
   * **Fungsi**: Menyaring baris tabel secara interaktif dan memberikan dialog konfirmasi `confirm()` sebelum menghapus baris tabel dari tampilan *front-end*.
5. **Validasi Form Client-Side & Penanganan Error**:
   * Menggunakan fungsi `initValidasiForm()`, `tampilkanError()`, dan `hapusError()`.
   * **Fungsi**: Memeriksa kelengkapan input form (Judul, Pengarang, Tahun, dan Stok) sebelum proses pengiriman form serta menampilkan pesan kesalahan langsung di bawah input terkait.

---

### 2. Kode CSS Lengkap (`assets/css/style.css`)

```css
html, body {
    height: 100%;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-color: #f8fafc;
    color: #2d3748;
    margin: 0;
}

main.container {
    flex: 1 0 auto;
}

.bg-theme {
    background-color: #1d5b8a !important;
}

.text-theme {
    color: #1d5b8a !important;
}

.btn-theme {
    background-color: #1d5b8a;
    color: #ffffff;
}

.btn-theme:hover {
    background-color: #17496e;
    color: #ffffff;
}

.nav-toggle-label {
    background: none;
    border: none;
    color: #ffffff;
    font-size: 1.5rem;
    cursor: pointer;
    display: none;
}

@media (max-width: 991.88px) {
    .nav-toggle-label {
        display: block;
    }
}

footer {
    flex-shrink: 0;
    width: 100%;
    background-color: #ffffff;
    border-top: 1px solid #e2e8f0;
    text-align: center;
    padding: 1.25rem 0;
    color: #64748b;
    font-size: 0.875rem;
    margin-top: auto;
}

footer p {
    margin: 0;
}
```


### 3. Kode JavaScript Lengkap (assets/js/app.js)

```
// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Konfirmasi hapus (front-end only, belum ke server) =====
function initHapusConfirm() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");
            const nama = row ? row.querySelector("td")?.textContent : "data ini";
            const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
            if (yakin && row) {
                row.remove();
            }
        });
    });
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        const judul = form.querySelector("[name='judul'], [name='nama']");
        if (judul && judul.value.trim() === "") {
            tampilkanError(judul, "Field ini wajib diisi.");
            valid = false;
        } else if (judul) {
            hapusError(judul);
        }

        const pengarang = form.querySelector("[name='pengarang']");
        if (pengarang && pengarang.value.trim() === "") {
            tampilkanError(pengarang, "Pengarang wajib diisi.");
            valid = false;
        } else if (pengarang) {
            hapusError(pengarang);
        }

        const tahun = form.querySelector("[name='tahun']");
        if (tahun) {
            const nilai = parseInt(tahun.value, 10);
            if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
                tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilai = parseInt(stok.value, 10);
            if (isNaN(nilai) || nilai < 0) {
                tampilkanError(stok, "Stok tidak boleh negatif.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});

```
