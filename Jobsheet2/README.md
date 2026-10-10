# Laporan 

<h4>Nama : Fafirru Hadzami Syach Mashuri<h4>
<h4>NIM : 254107020104<h4>
<h4>Kelas : TI-2D<h4>

### Modifikasi
1. #### Merubah warna tautan
```
a {
    color: #164869;
    text-decoration: none;
}
```

2. ##### Merubah warna menu utama dan menyesuaikan padding atas-bawah kanan-kiri menjadi 1.25rem
```
header {
    background-color: #164869;
    color: #fff;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
```

3. #### Merubah ukuran font SIMPUS
```
header h1 {
    font-size: 1.8rem;
}
```

4. #### Merubah jarak menu navigasi agar lebih rapat
```
header nav ul {
    list-style: none;
    display: flex;
    gap: 1rem;
}
```

5. #### Merubah font menjadi lebih tebal
```
header nav a {
    color: #fff;
    font-weight: 600;
}
```

6. #### Menambahkan sedikit space antara kotak
```
main section:nth-of-type(2) {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}
```

7. #### Menyesuaikan tabel agar tampil dibawah section h2
```
main section:nth-of-type(2) h2 {
    grid-column: 1 / -1;
}
```

8. #### Merubah warna kotak dan menyesuaikan lengkungan
```
main section:nth-of-type(2) article {
    background-color: #f7f9fb;
    border-radius: 4px;
    padding: 1.5rem;
    text-align: center;
}
```

9. #### Merubah warna dan menyesuaikan jarak judul dan isi
```
main section:nth-of-type(2) article h3 {
    font-size: 0.95rem;
    color: #444;
    margin-bottom: 0.35rem;
}
```

10. #### Merubah warna font
```
main section:nth-of-type(2) article p {
    font-size: 1.8rem;
    font-weight: 700;
    color: #164869;
}
```

11. #### Menyesuaikan jarak dan warna
```
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

```

12. #### Menyesuiakan ketebalan font, jarak, dan warna pada tabel
```
form label {
    display: block;
    margin-bottom: 0.35rem;
    font-weight: 500;
    color: #2b2b2b;
}

form input,
form select {
    width: 100%;
    max-width: 400px;
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
```

13. ##### Merubah warna dan jarak footer agar lebih jauh
```
footer {
    text-align: center;
    padding: 1.5rem;
    color: #55677a;
    font-size: 0.85rem;
}
```

