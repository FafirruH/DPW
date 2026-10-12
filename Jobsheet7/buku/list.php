<?php
session_start();
$pageTitle = 'Daftar Buku - SIMPUS-Mini';
$records = $_SESSION['buku'] ?? [];
include __DIR__ . '/../includes/header.php';
?>

<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 card-title-container">
                <h2 class="card-title mb-0 fw-bold">Daftar Buku</h2>
                <a href="tambah.php" class="btn btn-primary">+ Tambah Buku</a>
            </div>

            <div class="search-box mb-3">
                <label for="search-input" class="form-label">Cari Judul Buku</label>
                <input type="text" class="form-control" id="search-input" placeholder="Ketik judul buku...">
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Kategori</th>
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($records === []): ?>
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">Belum ada data buku. Silakan tambah
                                melalui menu "Tambah Buku".</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($records as $record): ?>
                        <?php $stok = (int) ($record['stok'] ?? 0); ?>
                        <tr>
                            <td class="fw-medium">
                                <?= htmlspecialchars((string) ($record['judul'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string) ($record['pengarang'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string) ($record['kategori'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="text-center">
                                <?= htmlspecialchars((string) ($record['tahun'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="text-center">
                                <?php if ($stok > 0): ?>
                                <span
                                    class="badge bg-success-subtle text-success border border-success-subtle"><?= $stok ?></span>
                                <?php else: ?>
                                <span
                                    class="badge bg-danger-subtle text-danger border border-danger-subtle"><?= $stok ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <form
                                    id="hapus-<?= htmlspecialchars((string) ($record['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                    action="proses_tambah.php" method="post"
                                    onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                    <input type="hidden" name="aksi" value="hapus">
                                    <input type="hidden" name="id"
                                        value="<?= htmlspecialchars((string) ($record['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                                </form>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-warning text-white">Edit</button>
                                    <button type="submit"
                                        form="hapus-<?= htmlspecialchars((string) ($record['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                        class="btn btn-danger btn-hapus">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>