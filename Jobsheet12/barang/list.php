<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Daftar Barang";
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

$flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']);
$daftarBarang = $pdo->query("SELECT * FROM barang ORDER BY id DESC")->fetchAll();
?>
<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h2 class="card-title h3 mb-0 fw-bold" style="color: #2c1d11">Daftar Barang</h2>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">Muat
                        Ulang</button>
                    <a href="/Jobsheet12/barang/tambah.php" class="btn btn-theme btn-sm">+ Tambah Barang</a>
                </div>
            </div>
            <?php if ($flash): ?><div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-3">
                <?= e($flash['pesan']) ?></div><?php endif; ?>

            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Produsen/Merek</th>
                            <th>Kategori</th>
                            <th class="text-center">Tgl Masuk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Stok</th>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?><th
                                class="text-center">Aksi</th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($daftarBarang)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data barang.</td>
                        </tr>
                        <?php else: foreach ($daftarBarang as $barang): ?>
                        <tr>
                            <td class="fw-semibold"><?= e($barang['nama']) ?></td>
                            <td><?= e($barang['produsen']) ?></td>
                            <td><span
                                    class="badge bg-light text-dark border"><?= e($barang['kategori'] ?? 'Umum') ?></span>
                            </td>
                            <td class="text-center">
                                <?= !empty($barang['tahun']) ? e(date('d/m/Y', strtotime($barang['tahun']))) : '-' ?>
                            </td>
                            <td class="text-end fw-semibold">Rp <?= number_format($barang['harga'] ?? 0, 0, ',', '.') ?>
                            </td>
                            <td class="text-center">
                                <?php if ($barang['stok'] <= 0): ?><span class="badge bg-danger">Habis</span>
                                <?php elseif ($barang['stok'] <= 5): ?><span
                                    class="badge bg-warning text-dark"><?= $barang['stok'] ?> pcs</span>
                                <?php else: ?><span class="badge bg-success"><?= $barang['stok'] ?>
                                    pcs</span><?php endif; ?>
                            </td>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <td class="text-center">
                                <a href="/Jobsheet12/barang/edit.php?id=<?= $barang['id'] ?>"
                                    class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                <form action="/Jobsheet12/barang/hapus.php" method="POST" class="d-inline m-0 p-0">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $barang['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus barang <?= addslashes($barang['nama']) ?>?');">Hapus</button>
                                </form>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
<script src="/assets/js/barang.js"></script>
<?php include __DIR__ . '/../includes/footer.php'; ?>