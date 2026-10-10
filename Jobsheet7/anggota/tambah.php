<?php
session_start();
$editId = trim((string) ($_GET['edit'] ?? ''));
$record = null;
if ($editId !== '') {
    foreach ($_SESSION['anggota'] ?? [] as $member) {
        if ((string) ($member['id'] ?? '') === $editId) {
            $record = $member;
            break;
        }
    }
    if ($record === null) {
        $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Data anggota tidak ditemukan.'];
        header('Location: list.php');
        exit;
    }
}
$pageTitle = ($record === null ? 'Tambah' : 'Edit') . ' Anggota - SIMPUS-Mini';
include __DIR__ . '/../includes/header.php';
?>

    <main class="container my-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title mb-4 fw-bold text-theme"><?= $record === null ? 'Tambah' : 'Edit' ?> Anggota</h2>
                <form id="form-tambah" action="proses_tambah.php" method="POST">
                    <?php if ($record !== null): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $record['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars((string) ($record['nama'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_anggota" class="form-label fw-semibold">No. Anggota</label>
                        <input type="text" class="form-control" id="no_anggota" name="no_anggota" value="<?= htmlspecialchars((string) ($record['no_anggota'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-semibold">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?= htmlspecialchars((string) ($record['alamat'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label fw-semibold">No. HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= htmlspecialchars((string) ($record['no_hp'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
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