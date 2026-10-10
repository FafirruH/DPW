<?php
session_start();
$pageTitle = 'Daftar Buku - SIMPUS-Mini';
$records = $_SESSION['buku'] ?? [];
include __DIR__ . '/../includes/header.php';
?>

    <main class="container my-4">
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3 card-title-container">
            <h2 class="card-title mb-0 fw-bold text-theme">
              Daftar Buku
            </h2>
            <a href="tambah.php" class="btn btn-theme">
              + Tambah Buku
            </a>
          </div>

          <div class="search-box mb-3">
            <label for="search-input" class="form-label">Cari Judul Buku</label>
            <input type="text" class="form-control" id="search-input" placeholder="Ketik judul buku..." />
          </div>
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
                  <td colspan="6" class="text-center text-secondary py-4">Belum ada data buku. Silakan tambah melalui menu "Tambah Buku".</td>
                </tr>
              <?php else: ?>
                <?php foreach ($records as $record): ?>
                <tr>
                  <td><?= htmlspecialchars((string) ($record['judul'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars((string) ($record['pengarang'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars((string) ($record['kategori'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="text-center"><?= htmlspecialchars((string) ($record['tahun'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="text-center"><?= htmlspecialchars((string) ($record['stok'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="text-center text-nowrap">
                    <a href="tambah.php?edit=<?= rawurlencode((string) ($record['id'] ?? '')) ?>" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                    <form action="proses_tambah.php" method="post" class="d-inline">
                      <input type="hidden" name="aksi" value="hapus">
                      <input type="hidden" name="id" value="<?= htmlspecialchars((string) ($record['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>

<?php include __DIR__ . '/../includes/footer.php'; ?>