# Laporan Praktikum SIMPUS

<h4>Nama : Fafirru Hadzami Syach Mashuri</h4>
<h4>NIM : 254107020104</h4>
<h4>Kelas : TI-2D</h4>

---

## Integrasi Data JSON, JS Table Renderer, Tombol Muat Ulang & Kolom Kategori Buku

### 1. Penjelasan Perubahan & Modifikasi Kode

Berikut adalah rincian penyesuaian yang diterapkan pada berkas HTML (`buku/list.html` & `anggota/list.html`), JavaScript spesifik (`buku.js` & `anggota.js`), serta struktur data JSON:

1. **Penyimpanan Data Berbasis JSON (`data/buku.json` & `data/anggota.json`)**:
   * Memisahkan data dari kode HTML dengan membuat berkas JSON untuk katalog buku (termasuk penambahan properti baru `"kategori"`) dan data anggota.
   * **Fungsi**: Memudahkan pengelolaan data secara terstruktur dan terpisah dari elemen tampilan.
2. **Rendering Tabel Dinamis Berbasis Asinkron (Fetch API)**:
   * Menggunakan fungsi `async/await` dan Fetch API di `buku.js` serta `anggota.js` untuk mengambil data dari JSON dan merender elemen `<tr>` serta `<td>` secara otomatis ke dalam `<tbody>`.
   * **Fungsi**: Memuat data secara dinamis tanpa perlu menuliskan baris tabel secara manual di kode HTML.
3. **Fitur Tombol "Muat Ulang" (`buku/list.html` & `buku.js`)**:
   * Menambahkan tombol `#btn-reload` di baris aksi header tabel yang memanggil kembali fungsi `muatDaftarBuku()`.
   * **Fungsi**: Memungkinkan pengguna untuk menyegarkan dan mengambil ulang data tabel buku dari server/JSON tanpa perlu *reload* halaman secara penuh.
4. **Penambahan Kolom Kategori Buku**:
   * Menambahkan elemen `<th>Kategori</th>` pada header tabel di `buku/list.html` dan menambahkan ekspresi `${item.kategori}` pada pembuatan baris tabel di `buku.js`.
   * **Fungsi**: Menampilkan informasi pengelompokan jenis/kategori untuk setiap buku pada daftar.

---

### 2. Berkas Data JSON

#### **a. Data Buku (`data/buku.json`)**
```json
[
    { "judul": "Laskar Pelangi", "pengarang": "Andrea Hirata", "tahun": 2005, "stok": 4, "kategori": "Novel" },
    { "judul": "Bumi Manusia", "pengarang": "Pramoedya Ananta Toer", "tahun": 1980, "stok": 2, "kategori": "Sastra" },
    { "judul": "Negeri 5 Menara", "pengarang": "Ahmad Fuadi", "tahun": 2009, "stok": 0, "kategori": "Novel" },
    { "judul": "Filosofi Teras", "pengarang": "Henry Manampiring", "tahun": 2018, "stok": 5, "kategori": "Self-Help" },
    { "judul": "Ronggeng Dukuh Paruk", "pengarang": "Ahmad Tohari", "tahun": 1982, "stok": 1, "kategori": "Sastra" },
    { "judul": "Cantik Itu Luka", "pengarang": "Eka Kurniawan", "tahun": 2002, "stok": 3, "kategori": "Novel" },
    { "judul": "Pulang", "pengarang": "Tere Liye", "tahun": 2015, "stok": 2, "kategori": "Fiksi" },
    { "judul": "Sang Pemimpi", "pengarang": "Andrea Hirata", "tahun": 2006, "stok": 6, "kategori": "Novel" },
    { "judul": "Perahu Kertas", "pengarang": "Dee Lestari", "tahun": 2009, "stok": 0, "kategori": "Romantis" },
    { "judul": "Gadis Kretek", "pengarang": "Ratih Kumala", "tahun": 2012, "stok": 4, "kategori": "Fiksi" }
]
```

#### **a. Data Buku (`data/anggota.json`)**
```json
[
    { "no_anggota": "A001", "nama": "Siti Aminah", "alamat": "Malang", "no_hp": "0812xxxx" },
    { "no_anggota": "A002", "nama": "Budi Santoso", "alamat": "Batu", "no_hp": "0813xxxx" },
    { "no_anggota": "A003", "nama": "Dewi Lestari", "alamat": "Malang", "no_hp": "0814xxxx" },
    { "no_anggota": "A004", "nama": "Rizky Firmansyah", "alamat": "Lawang", "no_hp": "0815xxxx" }
]
```
### 2. Berkas HTML Tampilan List

#### **a. Data Buku (`buku/list.html`)**
```HTML
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SIMPUS | Daftar Buku</title>
    <link href="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css)" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/style.css" />
  </head>
  <body>
    <header class="navbar navbar-expand-lg navbar-dark" style="background-color: #1d5b8a">
      <div class="container">
        <a class="navbar-brand fw-semibold" href="../index.html">SIMPUS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <nav class="collapse navbar-collapse" id="navMenu">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="../index.html">Beranda</a></li>
            <li class="nav-item"><a class="nav-link active" href="list.html">Daftar Buku</a></li>
            <li class="nav-item"><a class="nav-link" href="tambah.html">Tambah Buku</a></li>
            <li class="nav-item"><a class="nav-link" href="../anggota/list.html">Daftar Anggota</a></li>
            <li class="nav-item"><a class="nav-link" href="../anggota/tambah.html">Tambah Anggota</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main class="container my-4">
      <section class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3 card-title-container">
            <h2 class="card-title mb-0 fw-bold" style="color: #1d5b8a">Daftar Buku</h2>
            <div>
              <button type="button" id="btn-reload" class="btn btn-outline-secondary me-2">🔄 Muat Ulang</button>
              <a href="tambah.html" class="btn text-white" style="background-color: #1d5b8a">+ Tambah Buku</a>
            </div>
          </div>

          <div class="search-box mb-3">
            <label for="search-input" class="form-label">Cari Judul Buku</label>
            <input type="text" class="form-control" id="search-input" placeholder="Ketik judul buku..." />
          </div>
        </div>
        <p id="loading-indicator" class="px-3" style="display: none">Memuat data...</p>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Kategori</th>
                <th class="text-center">Tahun</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </section>
    </main>

    <footer>
      <p>&copy; 2026 SIMPUS &mdash; Jobsheet 6</p>
    </footer>

    <script src="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js)"></script>
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/buku.js"></script>
  </body>
</html>
```


#### **a. Data Anggota (`anggota/list.html`)**
```HTML
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SIMPUS | Daftar Anggota</title>
    <link href="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css)" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/style.css" />
  </head>
  <body>
    <header class="navbar navbar-expand-lg navbar-dark" style="background-color: #1d5b8a">
      <div class="container">
        <a class="navbar-brand fw-semibold" href="../index.html">SIMPUS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <nav class="collapse navbar-collapse" id="navMenu">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="../index.html">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="../buku/list.html">Daftar Buku</a></li>
            <li class="nav-item"><a class="nav-link" href="../buku/tambah.html">Tambah Buku</a></li>
            <li class="nav-item"><a class="nav-link active" href="list.html">Daftar Anggota</a></li>
            <li class="nav-item"><a class="nav-link" href="tambah.html">Tambah Anggota</a></li>
            <li class="nav-item"><a class="nav-link" href="../login.html">Login</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main class="container my-4">
      <section class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3 card-title-container">
            <h2 class="card-title mb-0 fw-bold" style="color: #1d5b8a">Daftar Anggota</h2>
            <a href="tambah.html" class="btn text-white" style="background-color: #1d5b8a">+ Tambah Anggota</a>
          </div>
          <div class="search-box mb-3">
            <label for="search-input" class="form-label">Cari Nama Anggota</label>
            <input type="text" class="form-control" id="search-input" placeholder="Ketik Nama Anggota..." />
          </div>
        </div>
        <p id="loading-indicator" class="px-3" style="display: none">Memuat data...</p>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>No. Anggota</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. HP</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </section>
    </main>

    <footer>
      <p>&copy; 2026 SIMPUS &mdash; Jobsheet 6</p>
    </footer>

    <script src="[https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js)"></script>
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/anggota.js"></script>
  </body>
</html>
```

### 3. JaavaScript

#### **a. asset/js/buku.js**
```JavaScript
// Mengambil & menampilkan Daftar Buku secara asinkron dari data/buku.json
async function muatDaftarBuku() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // simulasi delay jaringan agar loading indicator terlihat
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/buku.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarBuku = await res.json();

        daftarBuku.forEach(function (buku) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + buku.judul + "</td>" +
                "<td>" + buku.pengarang + "</td>" +
                "<td>" + buku.kategori + "</td>" +
                "<td>" + buku.tahun + "</td>" +
                "<td>" + buku.stok + "</td>" +
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarBuku);

document.addEventListener("DOMContentLoaded", function () {
    muatDaftarBuku();

    const reloadBtn = document.getElementById("btn-reload");
    if (reloadBtn) {
        reloadBtn.addEventListener("click", muatDaftarBuku);
    }
});
```

#### **b. asset/js/anggota.js**
```JavaScript
// Mengambil & menampilkan Daftar Anggota secara asinkron dari data/anggota.json
async function muatDaftarAnggota() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/anggota.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarAnggota = await res.json();

        daftarAnggota.forEach(function (anggota) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + anggota.no_anggota + "</td>" +
                "<td>" + anggota.nama + "</td>" +
                "<td>" + anggota.alamat + "</td>" +
                "<td>" + anggota.no_hp + "</td>" +
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarAnggota);

document.addEventListener("DOMContentLoaded", function () {
    muatDaftarAnggota();

    const reloadBtn = document.getElementById("btn-reload");
    if (reloadBtn) {
        reloadBtn.addEventListener("click", muatDaftarAnggota);
    }
});
```