<?php 
$page_title = "Daftar Barang";
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarBarang = $pdo->query("SELECT * FROM barang ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

    <main class="container my-4">
      <section class="card shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h2 class="card-title h3 mb-0 fw-bold" style="color: #2c1d11">
              Daftar Barang
            </h2>
            <div class="d-flex gap-2">
              <button type="button" id="btn-reload" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
                Muat Ulang
              </button>
              <a href="tambah.php" class="btn btn-theme btn-sm">
                + Tambah Barang
              </a>
            </div>
          </div>

          <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-3 alert-dismissible fade show">
              <?= htmlspecialchars($flash['pesan']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <div class="search-box mb-3">
            <label for="search-input" class="form-label fw-medium">Cari Barang</label>
            <input type="text" class="form-control" id="search-input" placeholder="Ketik nama barang atau merek..." />
          </div>

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
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
    <?php if (empty($daftarBarang)): ?>
      <tr>
        <td colspan="7" class="text-center text-muted py-4">Belum ada data barang. Silakan tambah barang baru.</td>
      </tr>
    <?php else: ?>
      <?php foreach ($daftarBarang as $buku): ?>
        <tr>
          <td class="fw-semibold"><?= htmlspecialchars($buku['judul']) ?></td>
          <td><?= htmlspecialchars($buku['pengarang']) ?></td>
          <td>
            <span class="badge bg-light text-dark border"><?= htmlspecialchars($buku['kategori'] ?? 'Umum') ?></span>
          </td>
          <td class="text-center">
              <?= !empty($buku['tahun']) ? htmlspecialchars(date('d/m/Y', strtotime($buku['tahun']))) : '-' ?>
          </td>
          <td class="text-end fw-semibold">
              Rp <?= number_format($buku['harga'] ?? 0, 0, ',', '.') ?>
          </td>
          <td class="text-center">
            <?php if ($buku['stok'] <= 0): ?>
              <span class="badge bg-danger">Habis</span>
            <?php elseif ($buku['stok'] <= 5): ?>
              <span class="badge bg-warning text-dark"><?= $buku['stok'] ?> pcs</span>
            <?php else: ?>
              <span class="badge bg-success"><?= $buku['stok'] ?> pcs</span>
            <?php endif; ?>
          </td>
          <td class="text-center">
            <a href="hapus.php?id=<?= $buku['id'] ?>" 
               class="btn btn-sm btn-outline-danger" 
               onclick="return confirm('Apakah Anda yakin ingin menghapus barang <?= htmlspecialchars(addslashes($buku['judul'])) ?>?');">
               Hapus
            </a>
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

    <script src="/assets/js/buku.js"></script>

<?php include __DIR__ . '/../includes/footer.php'; ?>