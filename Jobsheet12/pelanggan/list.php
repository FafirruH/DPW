<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Daftar Pelanggan";
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

$flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']);

$daftarPelanggan = $pdo->query("SELECT * FROM pelanggan ORDER BY id DESC")->fetchAll();
$daftarBarang    = $pdo->query("SELECT * FROM barang WHERE stok > 0 ORDER BY nama ASC")->fetchAll();
?>

<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h2 class="card-title h3 mb-0 fw-bold" style="color: #2c1d11">Daftar Pelanggan</h2>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">Muat
                        Ulang</button>
                    <a href="/Jobsheet12/pelanggan/tambah.php" class="btn btn-theme btn-sm">+ Tambah Pelanggan</a>
                </div>
            </div>

            <?php if ($flash): ?>
            <div
                class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-3 alert-dismissible fade show">
                <?= e($flash['pesan']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="search-box mb-3">
                <label for="search-input" class="form-label fw-medium">Cari Nama Pelanggan</label>
                <input type="text" class="form-control" id="search-input" placeholder="Ketik nama pelanggan..." />
            </div>

            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>No. Pelanggan</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($daftarPelanggan)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data pelanggan.</td>
                        </tr>
                        <?php else: foreach ($daftarPelanggan as $pelanggan): ?>
                        <tr>
                            <td><?= e($pelanggan['no_pelanggan']) ?></td>
                            <td class="fw-semibold"><?= e($pelanggan['nama']) ?></td>
                            <td><?= e($pelanggan['alamat'] ?? '-') ?></td>
                            <td><?= e($pelanggan['no_hp'] ?? '-') ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-success me-1" data-bs-toggle="modal"
                                    data-bs-target="#modalBeli<?= $pelanggan['id'] ?>">+ Beli Barang</button>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a href="/Jobsheet12/pelanggan/edit.php?id=<?= $pelanggan['id'] ?>"
                                    class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                <form action="/Jobsheet12/pelanggan/hapus.php" method="POST" class="d-inline m-0 p-0">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $pelanggan['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan <?= addslashes($pelanggan['nama']) ?>?');">Hapus</button>
                                </form>
                                <?php endif; ?>

                                
                                <div class="modal fade text-start" id="modalBeli<?= $pelanggan['id'] ?>" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="/Jobsheet12/pelanggan/proses_beli.php" method="POST">
                                                <?= csrf_field() ?>
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" style="color:#2c1d11;">Pilih Barang
                                                        untuk Dibeli</h5><button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_pelanggan"
                                                        value="<?= $pelanggan['id'] ?>">
                                                    <div class="mb-3"><label class="form-label fw-semibold">Nama
                                                            Pelanggan</label><input type="text" class="form-control"
                                                            value="<?= e($pelanggan['nama']) ?>" readonly></div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Pilih Barang yang
                                                            Tersedia</label>
                                                        <?php if (empty($daftarBarang)): ?><div
                                                            class="alert alert-warning mb-0 p-2 fs-6">Stok kosong.</div>
                                                        <?php else: ?>
                                                        <select class="form-select" name="id_barang" required>
                                                            <option value="" disabled selected>Pilih Barang</option>
                                                            <?php foreach ($daftarBarang as $b): ?>
                                                            <option value="<?= $b['id'] ?>"><?= e($b['nama']) ?> — Rp
                                                                <?= number_format($b['harga'], 0, ',', '.') ?> (Sisa:
                                                                <?= $b['stok'] ?>)</option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label fw-semibold">Jumlah
                                                            Pembelian (pcs)</label><input type="number"
                                                            class="form-control" name="jumlah" min="1" value="1"
                                                            required <?= empty($daftarBarang) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                                <div class="modal-footer"><button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button><button type="submit"
                                                        class="btn btn-success"
                                                        <?= empty($daftarBarang) ? 'disabled' : '' ?>>Konfirmasi
                                                        Pembelian</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
<script src="/assets/js/pelanggan.js"></script>
<?php include __DIR__ . '/../includes/footer.php'; ?>