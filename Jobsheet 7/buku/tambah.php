<?php include '../header.php'; ?>

    <main class="container my-4">
        <section class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title mb-4 fw-bold" style="color:#1d5b8a;">Tambah Buku</h2>
                <form id="form-tambah" action="list.php" method="POST">
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="pengarang" class="form-label fw-semibold">Pengarang</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label fw-semibold">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" min="1900" max="2026" required>
                    </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label fw-semibold">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn">
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label fw-semibold">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori">
                            <option value="fiksi">Fiksi</option>
                            <option value="non-fiksi">Non-Fiksi</option>
                            <option value="referensi">Referensi</option>
                        </select>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="btn text-white" style="background-color:#1d5b8a;">Simpan</button>
                        <a href="list.php" class="btn btn-secondary ms-1">Batal</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

<?php include '../footer.php'; ?>