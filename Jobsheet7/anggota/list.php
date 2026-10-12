<?php
session_start();
$pageTitle = 'Daftar Anggota - SIMPUS-Mini';
$records = $_SESSION['anggota'] ?? [];
include __DIR__ . '/../includes/header.php';
?>

<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 card-title-container">
                <h2 class="card-title mb-0 fw-bold">Daftar Anggota</h2>
                <a href="tambah.php" class="btn btn-primary">+ Tambah Anggota</a>
            </div>
            <div class="search-box mb-3">
                <label for="search-input" class="form-label">Cari Nama Anggota</label>
                <input type="text" class="form-control" id="search-input" placeholder="Ketik Nama Anggota...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No. Anggota</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($records === []): ?>
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-4">Belum ada data anggota. Silakan
                                tambah melalui menu "Tambah Anggota".</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($records as $record): ?>
                        <tr>
                            <td><span
                                    class="badge bg-secondary-subtle text-dark"><?= htmlspecialchars((string) ($record['no_anggota'] ?? ''), ENT_QUOTES, 'UTF-8') ?></span>
                            </td>
                            <td class="fw-medium">
                                <?= htmlspecialchars((string) ($record['nama'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string) ($record['alamat'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string) ($record['no_hp'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="text-center">
                                <form
                                    id="hapus-<?= htmlspecialchars((string) ($record['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                    action="proses_tambah.php" method="post"
                                    onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
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