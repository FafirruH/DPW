<?php 
$page_title = "Edit Pelanggan";
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID pelanggan tidak valid.'];
    header('Location: /Jobsheet9/pelanggan/list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM pelanggan WHERE id = :id");
$stmt->execute(['id' => (int)$id]);
$pelanggan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pelanggan) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data pelanggan tidak ditemukan.'];
    header('Location: /Jobsheet9/pelanggan/list.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="card-title h3 mb-4 fw-bold" style="color:#2c1d11;">Edit Pelanggan</h2>

            <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-3">
                <?= htmlspecialchars($flash['pesan']) ?>
            </div>
            <?php endif; ?>

            <form id="form-edit" action="/Jobsheet9/pelanggan/proses_edit.php" method="POST">
                <input type="hidden" name="id" value="<?= $pelanggan['id'] ?>">

                <div class="mb-3">
                    <label for="nama" class="form-label fw-semibold">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                        value="<?= htmlspecialchars($pelanggan['nama']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="no_pelanggan" class="form-label fw-semibold">No. Pelanggan</label>
                    <input type="text" class="form-control" id="no_pelanggan" name="no_pelanggan"
                        value="<?= htmlspecialchars($pelanggan['no_pelanggan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label fw-semibold">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat"
                        value="<?= htmlspecialchars($pelanggan['alamat'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label fw-semibold">No. HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp"
                        value="<?= htmlspecialchars($pelanggan['no_hp'] ?? '') ?>">
                </div>
                <div class="pt-2">
                    <button type="submit" class="btn btn-theme">Simpan Perubahan</button>
                    <a href="/Jobsheet9/pelanggan/list.php" class="btn btn-secondary ms-1">Batal</a>
                </div>
            </form>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>