<?php
require_once __DIR__ . '/../includes/functions.php';
$pageTitle = 'Daftar Anggota - SIMPUS-Mini';
$records = app_read_data('anggota');
include __DIR__ . '/../includes/header.php';
?>

    <main class="container my-4" data-api="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>api/data.php?type=anggota">
      <section class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3 card-title-container">
            <button type="button" id="btn-reload" class="btn btn-outline-secondary me-2">
              🔄 Muat Ulang
            </button>
            <h2 class="card-title mb-0 fw-bold" style="color: #1d5b8a">
              Daftar Anggota
            </h2>
            <a href="tambah.php" class="btn btn-theme">
              + Tambah Anggota
            </a>
          </div>
          <div class="search-box mb-3">
            <label for="search-input" class="form-label">Cari Nama Anggota</label>
            <input type="text" class="form-control" id="search-input" placeholder="Ketik Nama Anggota..." />
          </div>
        </div>
        <p id="loading-indicator" style="display: none">Memuat data...</p>
        <p id="table-error" class="text-danger px-3" role="alert" hidden></p>
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
              <?php foreach ($records as $record): ?>
                <tr>
                  <td><?= htmlspecialchars((string) ($record['no_anggota'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars((string) ($record['nama'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars((string) ($record['alamat'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars((string) ($record['no_hp'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="text-center text-nowrap">
                    <button type="button" class="btn btn-sm btn-outline-primary me-1" data-action="edit" data-id="<?= htmlspecialchars((string) ($record['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-action="delete" data-id="<?= htmlspecialchars((string) ($record['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">Hapus</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>

    <script src="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>assets/js/anggota.js"></script>

<?php include __DIR__ . '/../includes/footer.php'; ?>