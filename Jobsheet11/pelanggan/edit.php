<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Edit Pelanggan";
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) { $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID tidak valid.']; header('Location: /Jobsheet11/pelanggan/list.php'); exit; }
$stmt = $pdo->prepare("SELECT * FROM pelanggan WHERE id = :id"); $stmt->execute(['id' => (int)$id]);
$pelanggan = $stmt->fetch();
if (!$pelanggan) { header('Location: /Jobsheet11/pelanggan/list.php'); exit; }
$flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']);
?>
<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="card-title h3 mb-4 fw-bold" style="color:#2c1d11;">Edit Pelanggan</h2>
            <?php if ($flash): ?><div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-3">
                <?= e($flash['pesan']) ?></div><?php endif; ?>

            <form id="form-edit" action="/Jobsheet11/pelanggan/proses_edit.php" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $pelanggan['id'] ?>">
                <div class="mb-3"><label class="form-label fw-semibold">Nama Pelanggan</label><input type="text"
                        class="form-control" name="nama" value="<?= e($pelanggan['nama']) ?>" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">No. Pelanggan</label><input type="text"
                        class="form-control" name="no_pelanggan" value="<?= e($pelanggan['no_pelanggan']) ?>" required>
                </div>
                <div class="mb-3"><label class="form-label fw-semibold">Alamat</label><input type="text"
                        class="form-control" name="alamat" value="<?= e($pelanggan['alamat'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label fw-semibold">No. HP</label><input type="text"
                        class="form-control" name="no_hp" value="<?= e($pelanggan['no_hp'] ?? '') ?>"></div>
                <div class="pt-2"><button type="submit" class="btn btn-theme">Simpan Perubahan</button><a
                        href="/Jobsheet11/pelanggan/list.php" class="btn btn-secondary ms-1">Batal</a></div>
            </form>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>