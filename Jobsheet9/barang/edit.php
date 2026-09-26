<?php 
$page_title = "Edit Barang";
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID barang tidak valid.'];
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM barang WHERE id = :id");
$stmt->execute(['id' => (int)$id]);
$barang = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$barang) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data barang tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="card-title h3 mb-4 fw-bold" style="color:#2c1d11;">Edit Barang</h2>
            
            <?php if ($flash): ?>
                <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-3">
                    <?= htmlspecialchars($flash['pesan']) ?>
                </div>
            <?php endif; ?>

            <form id="form-edit" action="proses_edit.php" method="POST">
                <input type="hidden" name="id" value="<?= $barang['id'] ?>">

                <div class="mb-3">
                    <label for="nama" class="form-label fw-semibold">Nama Barang</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($barang['nama']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="produsen" class="form-label fw-semibold">Produsen / Merek</label>
                    <input type="text" class="form-control" id="produsen" name="produsen" value="<?= htmlspecialchars($barang['produsen']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tgl_masuk" class="form-label fw-semibold">Tanggal Barang Masuk</label>
                    <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk" value="<?= htmlspecialchars($barang['tahun']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="kode" class="form-label fw-semibold">Kode Barang / Barcode</label>
                    <input type="text" class="form-control" id="kode" name="kode" value="<?= htmlspecialchars($barang['kode'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label fw-semibold">Harga Barang (Rp)</label>
                    <input type="number" class="form-control" id="harga" name="harga" min="0" step="500" value="<?= (int)$barang['harga'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label fw-semibold">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" min="0" value="<?= (int)$barang['stok'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="kategori" class="form-label fw-semibold">Kategori Barang</label>
                    <select class="form-select" id="kategori" name="kategori" required>
                        <?php 
                        $categories = ["Sembako", "Makanan & Minuman", "Bumbu & Dapur", "Sabun & Kebersihan", "Obat & Kesehatan", "Lainnya"];
                        foreach ($categories as $cat): 
                        ?>
                            <option value="<?= $cat ?>" <?= ($barang['kategori'] === $cat) ? 'selected' : '' ?>><?= $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="pt-2">
                    <button type="submit" class="btn btn-theme">Simpan Perubahan</button>
                    <a href="list.php" class="btn btn-secondary ms-1">Batal</a>
                </div>
            </form>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>