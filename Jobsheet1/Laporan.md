# Laporan 

<h4>Nama : Fafirru Hadzami Syach Mashuri<h4>
<h4>NIM : 254107020104<h4>
<h4>Kelas : TI-2D<h4>

## Index
#### Kode 
```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMPUS | Beranda</title>
</head>
<body>
    <header>
        <h1>SIMPUS</h1>
        <nav>
            <ul>
                <li><a href="index.html">Beranda</a></li>
                <li><a href="buku/list.html">Daftar Buku</a></li>
                <li><a href="buku/tambah.html">Tambah Buku</a></li>
                <li><a href="anggota/list.html">Daftar Anggota</a></li>
                <li><a href="anggota/tambah.html">Tambah Anggota</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
            <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>
        </section>
        <section>
            <h2>Ringkasan</h2>
            <article>
                <h3>Total Buku</h3>
                <p>12</p>
            </article>
            <article>
                <h3>Total Anggota</h3>
                <p>8</p>
            </article>
            <article>
                <h3>Sedang Dipinjam</h3>
                <p>3</p>
            </article>
        </section>
    </main>
    <footer>
        <p>&copy; 2026 SIMPUS &mdash; Jobsheet 1</p>
    </footer>
</body>
</html>
```
#### Tampilan

<img width="608" height="686" alt="image" src="https://github.com/user-attachments/assets/7068bb57-6192-4e95-9b7f-d360141648d6" />

## Buku
### List
#### Kode
```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMPUS | Beranda</title>
</head>
<body>
    <header>
        <h1>SIMPUS</h1>
        <nav>
            <ul>
                <li><a href="index.html">Beranda</a></li>
                <li><a href="buku/list.html">Daftar Buku</a></li>
                <li><a href="buku/tambah.html">Tambah Buku</a></li>
                <li><a href="anggota/list.html">Daftar Anggota</a></li>
                <li><a href="anggota/tambah.html">Tambah Anggota</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
            <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>
        </section>

        <section>
            <h2>Ringkasan</h2>
            <article>
                <h3>Total Buku</h3>
                <p>12</p>
            </article>
            <article>
                <h3>Total Anggota</h3>
                <p>8</p>
            </article>
            <article>
                <h3>Sedang Dipinjam</h3>
                <p>3</p>
            </article>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIMPUS &mdash; Jobsheet 1</p>
    </footer>
</body>
</html>
```

#### Tampilan

<img width="648" height="506" alt="image" src="https://github.com/user-attachments/assets/67f177ca-42e4-4f8a-9ed1-3592cb363d97" />

### Tambah
#### Kode
```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMPUS | Tambah Buku</title>
</head>
<body>
    <header>
        <h1>SIMPUS</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Beranda</a></li>
                <li><a href="list.html">Daftar Buku</a></li>
                <li><a href="tambah.html">Tambah Buku</a></li>
                <li><a href="../anggota/list.html">Daftar Anggota</a></li>
                <li><a href="../anggota/tambah.html">Tambah Anggota</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Tambah Buku</h2>
            <form>
                <p>
                    <label for="judul">Judul</label><br>
                    <input type="text" id="judul" name="judul" required>
                </p>
                <p>
                    <label for="pengarang">Pengarang</label><br>
                    <input type="text" id="pengarang" name="pengarang" required>
                </p>
                <p>
                    <label for="tahun">Tahun Terbit</label><br>
                    <input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
                </p>
                <p>
                    <label for="isbn">ISBN</label><br>
                    <input type="text" id="isbn" name="isbn">
                </p>
                <p>
                    <label for="stok">Stok</label><br>
                    <input type="number" id="stok" name="stok" min="0" required>
                </p>
                <p>
                    <label for="kategori">Kategori</label><br>
                    <select id="kategori" name="kategori">
                        <option value="fiksi">Fiksi</option>
                        <option value="non-fiksi">Non-Fiksi</option>
                        <option value="referensi">Referensi</option>
                    </select>
                </p>
                <p>
                    <button type="submit">Simpan</button>
                </p>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIMPUS &mdash; Jobsheet 1</p>
    </footer>
</body>
</html>
```
#### Tampilan

<img width="265" height="755" alt="image" src="https://github.com/user-attachments/assets/fb49b03c-a323-4a7f-badd-1af9b6530df0" />

## Anggota
### List
#### Kode
```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMPUS | Daftar Anggota</title>
</head>
<body>
    <header>
        <h1>SIMPUS</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Beranda</a></li>
                <li><a href="../buku/list.html">Daftar Buku</a></li>
                <li><a href="../buku/tambah.html">Tambah Buku</a></li>
                <li><a href="list.html">Daftar Anggota</a></li>
                <li><a href="tambah.html">Tambah Anggota</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Daftar Anggota</h2>
            <table>
                <thead>
                    <tr>
                        <th>No. Anggota</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A001</td>
                        <td>Siti Aminah</td>
                        <td>Malang</td>
                        <td>0812xxxx</td>
                        <td>
                            <button type="button">Edit</button>
                            <button type="button">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>A002</td>
                        <td>Budi Santoso</td>
                        <td>Batu</td>
                        <td>0813xxxx</td>
                        <td>
                            <button type="button">Edit</button>
                            <button type="button">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIMPUS &mdash; Jobsheet 1</p>
    </footer>
</body>
</html>
```
#### Tampilan

<img width="509" height="409" alt="image" src="https://github.com/user-attachments/assets/6c206abe-8582-4c5c-9956-98c94aa13a55" />


### Tambah
#### Kode
```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMPUS | Tambah Anggota</title>
</head>
<body>
    <header>
        <h1>SIMPUS</h1>
        <nav>
            <ol>
                <li><a href="../index.html">Beranda</a></li>
                <li><a href="../buku/list.html">Daftar Buku</a></li>
                <li><a href="../buku/tambah.html">Tambah Buku</a></li>
                <li><a href="list.html">Daftar Anggota</a></li>
                <li><a href="tambah.html">Tambah Anggota</a></li>
            </ol>
        </nav>
    </header>

    <main>
        <section>
            <h2>Tambah Anggota</h2>
            <form>
                <p>
                    <label for="nama">Nama</label><br>
                    <input type="text" id="nama" name="nama" required>
                </p>
                <p>
                    <label for="no_anggota">No. Anggota</label><br>
                    <input type="text" id="no_anggota" name="no_anggota" required>
                </p>
                <p>
                    <label for="alamat">Alamat</label><br>
                    <input type="text" id="alamat" name="alamat">
                </p>
                <p>
                    <label for="no_hp">No. HP</label><br>
                    <input type="text" id="no_hp" name="no_hp">
                </p>
                <p>
                    <button type="submit">Simpan</button>
                </p>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIMPUS &mdash; Jobsheet 1</p>
    </footer>
</body>
</html>
```
#### Tampilan

<img width="288" height="629" alt="image" src="https://github.com/user-attachments/assets/55119d98-6fdd-489e-a9fe-9ea2451e68ab" />

## Latihan Reflektif
1. Karena alamat dan no hp merupakan data opsional sehingga tidak diberi required
2. Akan muncul please fill out this field di dield yang memiliki requiered

<img width="284" height="632" alt="image" src="https://github.com/user-attachments/assets/e39680c0-1912-422e-a755-e2d742f49d32" />

3. Refresh
