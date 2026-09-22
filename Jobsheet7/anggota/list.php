<?php include '../header.php'; ?>

    <main class="container my-4">
      <section class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3 card-title-container">
            <button type="button" id="btn-reload" class="btn btn-outline-secondary me-2">
              🔄 Muat Ulang
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
            <tbody></tbody>
          </table>
        </div>
      </section>
    </main>

    <!-- Memanggil file JavaScript khusus anggota sebelum footer -->
    <script src="../assets/js/anggota.js"></script>

<?php include '../footer.php'; ?>