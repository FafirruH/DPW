<?php
session_start();
$editId = trim((string) ($_GET['edit'] ?? ''));
$record = null;
if ($editId !== '') {
    foreach ($_SESSION['buku'] ?? [] as $book) {
        if ((string) ($book['id'] ?? '') === $editId) {
            $record = $book;
            break;
        }
    }
    if ($record === null) {
        $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Data buku tidak ditemukan.'];
        header('Location: list.php');
        exit;
    }
}
$pageTitle = ($record === null ? 'Tambah' : 'Edit') . ' Buku - SIMPUS-Mini';
include __DIR__ . '/../includes/header.php';
?>

    <main class="container my-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title mb-4 fw-bold text-theme"><?= $record === null ? 'Tambah' : 'Edit' ?> Buku</h2>
                <form id="form-tambah" action="proses_tambah.php" method="POST">
                    <?php if ($record !== null): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $record['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="<?= htmlspecialchars((string) ($record['judul'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="pengarang" class="form-label fw-semibold">Pengarang</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?= htmlspecialchars((string) ($record['pengarang'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label fw-semibold">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" min="1900" max="<?= date('Y') ?>" value="<?= htmlspecialchars((string) ($record['tahun'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label fw-semibold">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" value="<?= htmlspecialchars((string) ($record['isbn'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label fw-semibold">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" min="0" value="<?= htmlspecialchars((string) ($record['stok'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori">
                            <option value="fiksi" <?= ($record['kategori'] ?? 'fiksi') === 'fiksi' ? 'selected' : '' ?>>Fiksi</option>
                            <option value="non-fiksi" <?= ($record['kategori'] ?? '') === 'non-fiksi' ? 'selected' : '' ?>>Non-Fiksi</option>
                            <option value="referensi" <?= ($record['kategori'] ?? '') === 'referensi' ? 'selected' : '' ?>>Referensi</option>
                        </select>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="btn btn-theme">Simpan</button>
                        <a href="list.php" class="btn btn-secondary ms-1">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>