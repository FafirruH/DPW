<?php 
$page_title = "Tambah Barang";
include __DIR__ . '/../includes/header.php'; 

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

    <main class="container my-4">
        <section class="card shadow-sm mb-4">
            <div class="card-body p-4">
                <h2 class="card-title h3 mb-4 fw-bold" style="color:#2c1d11;">Tambah Barang</h2>
                
                <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-3">
                        <?= htmlspecialchars($flash['pesan']) ?>
                    </div>
                <?php endif; ?>

                <form id="form-tambah" action="proses_tambah.php" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Barang</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Minyak Goreng Bimoli 1L" required>
                    </div>
                    <div class="mb-3">
                        <label for="produsen" class="form-label fw-semibold">Produsen / Merek</label>
                        <input type="text" class="form-control" id="produsen" name="produsen" placeholder="Contoh: PT Indofood" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_masuk" class="form-label fw-semibold">Tanggal Barang Masuk</label>
                        <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk" required>
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label fw-semibold">Kode Barang</label>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Contoh: 899123456789">
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label fw-semibold">Harga Barang (Rp)</label>
                        <input type="number" class="form-control" id="harga" name="harga" min="0" step="500" placeholder="Contoh: 18000" required>
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label fw-semibold">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" min="0" placeholder="Contoh: 24" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori Barang</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Sembako">Sembako</option>
                            <option value="Makanan & Minuman">Makanan & Minuman Ringan</option>
                            <option value="Bumbu & Dapur">Bumbu & Bahan Dapur</option>
                            <option value="Sabun & Kebersihan">Perlengkapan Mandi & Cuci</option>
                            <option value="Obat & Kesehatan">Obat & Kesehatan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="btn btn-theme">Simpan</button>
                        <a href="list.php" class="btn btn-secondary ms-1">Batal</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>