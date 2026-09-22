<?php 
$page_title = "Tambah Pelanggan";
include __DIR__ . '/../includes/header.php'; 

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

    <main class="container my-4">
        <section class="card shadow-sm mb-4">
            <div class="card-body p-4">
                <h2 class="card-title h3 mb-4 fw-bold" style="color:#2c1d11;">Tambah Pelanggan</h2>

                <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-3">
                        <?= htmlspecialchars($flash['pesan']) ?>
                    </div>
                <?php endif; ?>

                <form id="form-tambah" action="proses_tambah.php" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_anggota" class="form-label fw-semibold">No. Pelanggan</label>
                        <input type="text" class="form-control" id="no_anggota" name="no_anggota" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-semibold">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label fw-semibold">No. HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp">
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