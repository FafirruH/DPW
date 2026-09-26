<?php 
$page_title = "Beranda";
require_once __DIR__ . '/includes/koneksi.php';
include __DIR__ . '/includes/header.php'; 

try {
    $stmtBarang = $pdo->query("SELECT COUNT(*) AS total FROM barang");
    $totalBarang = $stmtBarang->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
} catch (PDOException $e) {
    $totalBarang = 0;
}

try {
    $stmtPelanggan = $pdo->query("SELECT COUNT(*) AS total FROM pelanggan");
    $totalPelanggan = $stmtPelanggan->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
} catch (PDOException $e) {
    $totalPelanggan = 0;
}

try {
    $stmtPenghasilan = $pdo->query("
        SELECT COALESCE(SUM(nominal), 0) AS total 
        FROM transaksi 
        WHERE jenis = 'masuk' 
          AND date_trunc('month', tanggal) = date_trunc('month', CURRENT_DATE)
    ");
    $penghasilanBulanIni = $stmtPenghasilan->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
} catch (PDOException $e) {
    $penghasilanBulanIni = 0;
}

try {
    $stmtPengeluaran = $pdo->query("
        SELECT COALESCE(SUM(nominal), 0) AS total 
        FROM transaksi 
        WHERE jenis = 'keluar' 
          AND date_trunc('month', tanggal) = date_trunc('month', CURRENT_DATE)
    ");
    $pengeluaranBulanIni = $stmtPengeluaran->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
} catch (PDOException $e) {
    $pengeluaranBulanIni = 0;
}

$profitBersih = $penghasilanBulanIni - $pengeluaranBulanIni;

try {
    $stmtStokKritis = $pdo->query("SELECT judul, stok FROM barang WHERE stok <= 5 ORDER BY stok ASC LIMIT 5");
    $stokKritis = $stmtStokKritis->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $stokKritis = [];
}

try {
    $stmtTrxTerakhir = $pdo->query("SELECT * FROM transaksi ORDER BY id DESC LIMIT 5");
    $transaksiTerakhir = $stmtTrxTerakhir->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $transaksiTerakhir = [];
}
?>

<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="card-title h3 mb-1" style="color:#2c1d11;">Manajemen Toko Madura</h2>
                <p class="text-secondary mb-0">Kelola persediaan barang, pelanggan, dan arus kas harian toko dengan
                    mudah.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="/Jobsheet9/barang/tambah.php" class="btn btn-theme btn-sm">+ Tambah Barang</a>
                <a href="/Jobsheet9/pelanggan/tambah.php" class="btn btn-outline-secondary btn-sm">+ Tambah
                    Pelanggan</a>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <h4 class="fw-bold mb-3" style="color:#2c1d11;">Ringkasan Keuangan & Stok</h4>
        <div class="row g-3">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card" style="background-color:#f8fafc; border-color:#e6ddc4;">
                    <span class="text-secondary fw-semibold fs-6">Total Barang</span>
                    <p class="fs-2 fw-bold mb-0 mt-2" style="color:#2c1d11;"><?= htmlspecialchars($totalBarang) ?></p>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card" style="background-color:#f8fafc; border-color:#e6ddc4;">
                    <span class="text-secondary fw-semibold fs-6">Total Pelanggan</span>
                    <p class="fs-2 fw-bold mb-0 mt-2" style="color:#2c1d11;"><?= htmlspecialchars($totalPelanggan) ?>
                    </p>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card" style="background-color:#f0fdf4; border-color:#bbf7d0;">
                    <span class="text-success fw-semibold fs-6">Penghasilan (Bulan Ini)</span>
                    <p class="fs-4 fw-bold mb-0 mt-2 text-success">Rp
                        <?= number_format($penghasilanBulanIni, 0, ',', '.') ?></p>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card" style="background-color:#fef2f2; border-color:#fecaca;">
                    <span class="text-danger fw-semibold fs-6">Pengeluaran (Bulan Ini)</span>
                    <p class="fs-4 fw-bold mb-0 mt-2 text-danger">Rp
                        <?= number_format($pengeluaranBulanIni, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-12 col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3" style="color:#2c1d11;">Peringatan Stok Menipis</h5>
                    <?php if (empty($stokKritis)): ?>
                    <p class="text-muted mb-0 fs-6">Semua stok barang dalam kondisi aman.</p>
                    <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($stokKritis as $barang): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="fw-medium text-dark"><?= htmlspecialchars($barang['judul']) ?></span>
                            <?php if ($barang['stok'] <= 0): ?>
                            <span class="badge bg-danger">Habis</span>
                            <?php else: ?>
                            <span class="badge bg-warning text-dark">Sisa <?= $barang['stok'] ?> pcs</span>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="mt-3 text-end">
                        <a href="/Jobsheet9/barang/list.php" class="text-decoration-none small fw-semibold"
                            style="color:#5c3d2e;">Lihat Semua Barang &rarr;</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3" style="color:#2c1d11;">Transaksi Terbaru</h5>
                    <?php if (empty($transaksiTerakhir)): ?>
                    <p class="text-muted mb-0 fs-6">Belum ada aktivitas transaksi pencatatan kas.</p>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaksiTerakhir as $trx): ?>
                                <tr>
                                    <td class="small text-muted">
                                        <?= htmlspecialchars(date('d/m/Y', strtotime($trx['tanggal']))) ?></td>
                                    <td class="small fw-medium"><?= htmlspecialchars($trx['keterangan']) ?></td>
                                    <td
                                        class="text-end fw-bold small <?= $trx['jenis'] === 'masuk' ? 'text-success' : 'text-danger' ?>">
                                        <?= $trx['jenis'] === 'masuk' ? '+' : '-' ?> Rp
                                        <?= number_format($trx['nominal'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>