<?php 
$page_title = "Daftar Pelanggan";
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarPelanggan = $pdo->query("SELECT * FROM pelanggan ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$daftarBarang    = $pdo->query("SELECT * FROM barang WHERE stok > 0 ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container my-4">
  <section class="card shadow-sm mb-4">
    <div class="card-body p-4">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="card-title h3 mb-0 fw-bold" style="color: #2c1d11">
          Daftar Pelanggan
        </h2>
        <div class="d-flex gap-2">
          <button type="button" id="btn-reload" class="btn btn-outline-secondary btn-sm" onclick="location.reload();">
            Muat Ulang
          </button>
          <a href="/Jobsheet8/pelanggan/tambah.php" class="btn btn-theme btn-sm">
            + Tambah Pelanggan
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
    <td colspan="5" class="text-center text-muted py-4">Belum ada data pelanggan. Silakan tambah pelanggan baru.</td>
  </tr>
<?php else: ?>
  <?php foreach ($daftarPelanggan as $pelanggan): ?>
    <tr>
      <td><?= htmlspecialchars($pelanggan['no_pelanggan']) ?></td>
      <td class="fw-semibold"><?= htmlspecialchars($pelanggan['nama']) ?></td>
      <td><?= htmlspecialchars($pelanggan['alamat'] ?? '-') ?></td>
      <td><?= htmlspecialchars($pelanggan['no_hp'] ?? '-') ?></td>
      <td class="text-center">
        <button type="button" class="btn btn-sm btn-success me-1" data-bs-toggle="modal" data-bs-target="#modalBeli<?= $pelanggan['id'] ?>">
          + Beli Barang
        </button>
        <a href="/Jobsheet8/pelanggan/hapus.php?id=<?= $pelanggan['id'] ?>" 
           class="btn btn-sm btn-outline-danger" 
           onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan <?= htmlspecialchars(addslashes($pelanggan['nama'])) ?>?');">
           Hapus
        </a>
        
        <div class="modal fade text-start" id="modalBeli<?= $pelanggan['id'] ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="/Jobsheet8/pelanggan/proses_beli.php" method="POST">
                <div class="modal-header">
                  <h5 class="modal-title fw-bold" style="color:#2c1d11;">Pilih Barang untuk Dibeli</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id_pelanggan" value="<?= $pelanggan['id'] ?>">
                  
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Pelanggan</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($pelanggan['nama']) ?>" readonly>
                  </div>

                  <div class="mb-3">
                    <label for="id_barang_<?= $pelanggan['id'] ?>" class="form-label fw-semibold">Pilih Barang yang Tersedia</label>
                    <?php if (empty($daftarBarang)): ?>
                      <div class="alert alert-warning mb-0 p-2 fs-6">
                        Stok semua barang sedang kosong/belum ada barang.
                      </div>
                    <?php else: ?>
                      <select class="form-select" name="id_barang" id="id_barang_<?= $pelanggan['id'] ?>" required>
                        <option value="" disabled selected>Pilih Barang</option>
                        <?php foreach ($daftarBarang as $b): ?>
                          <option value="<?= $b['id'] ?>">
                            <?= htmlspecialchars($b['nama']) ?> — Rp <?= number_format($b['harga'], 0, ',', '.') ?> (Sisa Stok: <?= $b['stok'] ?>)
                          </option>
                        <?php endforeach; ?>
                      </select>
                    <?php endif; ?>
                  </div>

                  <div class="mb-3">
                    <label for="jumlah_<?= $pelanggan['id'] ?>" class="form-label fw-semibold">Jumlah Pembelian (pcs)</label>
                    <input type="number" class="form-control" name="jumlah" id="jumlah_<?= $pelanggan['id'] ?>" min="1" value="1" required <?= empty($daftarBarang) ? 'disabled' : '' ?>>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-success" <?= empty($daftarBarang) ? 'disabled' : '' ?>>Konfirmasi Pembelian</button>
                </div>
              </form>
            </div>
          </div>
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

<script src="/assets/js/pelanggan.js"></script>

<?php include __DIR__ . '/../includes/footer.php'; ?>