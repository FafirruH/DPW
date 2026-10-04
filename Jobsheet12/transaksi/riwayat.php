<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Riwayat Transaksi";
require_once __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php'; 

$pelangganId = $_GET['pelanggan_id'] ?? '';
$daftarPelanggan = $pdo->query("SELECT * FROM pelanggan ORDER BY nama ASC")->fetchAll();

$riwayat = [];
if ($pelangganId !== '') {
    $stmt = $pdo->prepare(
        "SELECT t.tanggal, t.jenis, t.jumlah, t.nominal, b.nama AS nama_barang 
         FROM transaksi t
         LEFT JOIN barang b ON b.id = t.barang_id
         WHERE t.pelanggan_id = :pelanggan_id 
         ORDER BY t.tanggal DESC, t.id DESC"
    );
    $stmt->execute(['pelanggan_id' => $pelangganId]);
    $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="card-title h3 mb-4 fw-bold" style="color: #2c1d11">Riwayat Pembelian Pelanggan</h2>

            <form method="GET" action="riwayat.php" class="row g-3 align-items-end mb-4 bg-light p-3 rounded">
                <div class="col-12 col-md-6">
                    <label for="pelanggan_id" class="form-label fw-medium">Pilih Pelanggan</label>
                    <select id="pelanggan_id" name="pelanggan_id" class="form-select" required>
                        <option value="" disabled <?= $pelangganId === '' ? 'selected' : '' ?>>Pilih Nama Pelanggan
                        </option>
                        <?php foreach ($daftarPelanggan as $p): ?>
                        <option value="<?= $p['id'] ?>"
                            <?= (string)$pelangganId === (string)$p['id'] ? 'selected' : '' ?>>
                            <?= e($p['nama']) ?> (<?= e($p['no_pelanggan']) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-theme">Tampilkan Riwayat</button>
                    <?php if($pelangganId !== ''): ?>
                    <a href="riwayat.php" class="btn btn-outline-secondary ms-1">Reset</a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if ($pelangganId !== ''): ?>
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang yang Dibeli</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Total Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($riwayat)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada riwayat transaksi untuk
                                pelanggan ini.</td>
                        </tr>
                        <?php else: foreach ($riwayat as $r): ?>
                        <tr>
                            <td><?= e(date('d/m/Y', strtotime($r['tanggal']))) ?></td>
                            <td class="fw-semibold"><?= e($r['nama_barang'] ?? 'Barang Telah Dihapus') ?></td>
                            <td class="text-center"><?= e($r['jumlah']) ?> pcs</td>
                            <td class="text-end fw-bold text-success">+ Rp
                                <?= number_format($r['nominal'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>