<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Barang";
include __DIR__ . '/../includes/header.php'; 
$flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']);
?>
<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="card-title h3 mb-4 fw-bold" style="color:#2c1d11;">Tambah Barang</h2>
            <?php if ($flash): ?><div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-3">
                <?= e($flash['pesan']) ?></div><?php endif; ?>

            <form id="form-tambah" action="proses_tambah.php" method="POST">
                <?= csrf_field() ?>
                <div class="mb-3"><label class="form-label fw-semibold">Nama Barang</label><input type="text"
                        class="form-control" name="nama" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">Produsen / Merek</label><input type="text"
                        class="form-control" name="produsen" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">Tanggal Barang Masuk</label><input type="date"
                        class="form-control" name="tgl_masuk" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">Kode Barang</label><input type="text"
                        class="form-control" name="kode"></div>
                <div class="mb-3"><label class="form-label fw-semibold">Harga Barang (Rp)</label><input type="number"
                        class="form-control" name="harga" min="0" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">Stok</label><input type="number"
                        class="form-control" name="stok" min="0" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">Kategori Barang</label>
                    <select class="form-select" name="kategori" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option value="Sembako">Sembako</option>
                        <option value="Makanan & Minuman">Makanan & Minuman Ringan</option>
                        <option value="Bumbu & Dapur">Bumbu & Bahan Dapur</option>
                        <option value="Sabun & Kebersihan">Perlengkapan Mandi & Cuci</option>
                        <option value="Obat & Kesehatan">Obat & Kesehatan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="pt-2"><button type="submit" class="btn btn-theme">Simpan</button><a href="list.php"
                        class="btn btn-secondary ms-1">Batal</a></div>
            </form>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>