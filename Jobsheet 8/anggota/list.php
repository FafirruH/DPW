<?php 
$page_title = "Daftar Anggota";
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$daftarAnggota = $pdo->query("SELECT * FROM anggota ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

    <main class="container my-4">
      <section class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3 card-title-container">
            <button type="button" id="btn-reload" class="btn btn-outline-secondary me-2">
              Muat Ulang
            </button>
            <h2 class="card-title mb-0 fw-bold" style="color: #1d5b8a">
              Daftar Anggota
            </h2>
            <a href="tambah.php" class="btn text-white" style="background-color: #1d5b8a">
              + Tambah Anggota
            </a>
          </div>
          <div class="search-box mb-3">
            <label for="search-input" class="form-label">Cari Nama Anggota</label>
            <input type="text" class="form-control" id="search-input" placeholder="Ketik Nama Anggota..." />
          </div>
        </div>
        <p id="loading-indicator" style="display: none">Memuat data...</p>
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
  <?php if (empty($daftarAnggota)): ?>
    <tr>
      <td colspan="5" class="text-center text-muted">Belum ada data anggota.</td>
    </tr>
  <?php else: ?>
    <?php foreach ($daftarAnggota as $anggota): ?>
      <tr>
        <td><?= htmlspecialchars($anggota['no_anggota']) ?></td>
        <td><?= htmlspecialchars($anggota['nama']) ?></td>
        <td><?= htmlspecialchars($anggota['alamat'] ?? '-') ?></td>
        <td><?= htmlspecialchars($anggota['no_hp'] ?? '-') ?></td>
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

    <script src="../assets/js/anggota.js"></script>

<?php include __DIR__ . '/../includes/footer.php'; ?>