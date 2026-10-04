<?php
require __DIR__ . '/../includes/auth.php';  
$page_title = "Edit Barang";
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) { header('Location: list.php'); exit; }
$stmt = $pdo->prepare("SELECT * FROM barang WHERE id = :id"); $stmt->execute(['id' => (int)$id]);
$barang = $stmt->fetch();
if (!$barang) { header('Location: list.php'); exit; }
$flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']);
?>
<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="card-title h3 mb-4 fw-bold" style="color:#2c1d11;">Edit Barang</h2>
            <?php if ($flash): ?><div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-3">
                <?= e($flash['pesan']) ?></div><?php endif; ?>

            <form id="form-edit" action="proses_edit.php" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $barang['id'] ?>">
                <div class="mb-3"><label class="form-label fw-semibold">Nama Barang</label><input type="text"
                        class="form-control" name="nama" value="<?= e($barang['nama']) ?>" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">Produsen / Merek</label><input type="text"
                        class="form-control" name="produsen" value="<?= e($barang['produsen']) ?>" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">Tanggal Barang Masuk</label><input type="date"
                        class="form-control" name="tgl_masuk" value="<?= e($barang['tahun']) ?>" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">Kode Barang / Barcode</label><input type="text"
                        class="form-control" name="kode" value="<?= e($barang['kode'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label fw-semibold">Harga Barang (Rp)</label><input type="number"
                        class="form-control" name="harga" min="0" value="<?= (int)$barang['harga'] ?>" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">Stok</label><input type="number"
                        class="form-control" name="stok" min="0" value="<?= (int)$barang['stok'] ?>" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">Kategori Barang</label>
                    <select class="form-select" name="kategori" required>
                        <?php foreach (["Sembako", "Makanan & Minuman", "Bumbu & Dapur", "Sabun & Kebersihan", "Obat & Kesehatan", "Lainnya"] as $cat): ?>
                        <option value="<?= $cat ?>" <?= ($barang['kategori'] === $cat) ? 'selected' : '' ?>><?= $cat ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="pt-2"><button type="submit" class="btn btn-theme">Simpan Perubahan</button><a
                        href="list.php" class="btn btn-secondary ms-1">Batal</a></div>
            </form>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>