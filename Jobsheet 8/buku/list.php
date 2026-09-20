<?php 
$page_title = "Daftar Buku";
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$daftarBuku = $pdo->query("SELECT * FROM buku ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

    <main class="container my-4">
      <section class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3 card-title-container">
            <button type="button" id="btn-reload" class="btn btn-outline-secondary me-2">
              Muat Ulang
            </button>
            <h2 class="card-title mb-0 fw-bold" style="color: #1d5b8a">
              Daftar Buku
            </h2>
            <a href="tambah.php" class="btn text-white" style="background-color: #1d5b8a">
              + Tambah Buku
            </a>
          </div>

          <div class="search-box mb-3">
            <label for="search-input" class="form-label">Cari Judul Buku</label>
            <input type="text" class="form-control" id="search-input" placeholder="Ketik judul buku..." />
          </div>
        </div>
        <p id="loading-indicator" style="display: none">Memuat data...</p>
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
  <?php if (empty($daftarBuku)): ?>
    <tr>
      <td colspan="6" class="text-center text-muted">Belum ada data buku.</td>
    </tr>
  <?php else: ?>
    <?php foreach ($daftarBuku as $buku): ?>
      <tr>
        <td><?= htmlspecialchars($buku['judul']) ?></td>
        <td><?= htmlspecialchars($buku['pengarang']) ?></td>
        <td><?= htmlspecialchars($buku['kategori'] ?? '-') ?></td>
        <td class="text-center"><?= htmlspecialchars($buku['tahun']) ?></td>
        <td class="text-center"><?= htmlspecialchars($buku['stok']) ?></td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-outline-primary me-1">Edit</button>
          <button type="button" class="btn btn-sm btn-outline-danger btn-hapus">Hapus</button>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
</tbody>
          </table>
        </div>
      </section>
    </main>

    <script src="../assets/js/buku.js"></script>

<?php include __DIR__ . '/../includes/footer.php'; ?>