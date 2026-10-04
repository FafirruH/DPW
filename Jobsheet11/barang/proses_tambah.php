<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';
csrf_verify();

$nama = trim($_POST['nama'] ?? ''); $produsen = trim($_POST['produsen'] ?? ''); $tglMasuk = $_POST['tgl_masuk'] ?? '';
$kode = trim($_POST['kode'] ?? ''); $harga = $_POST['harga'] ?? 0; $stok = $_POST['stok'] ?? 0; $kategori = trim($_POST['kategori'] ?? '');

if ($nama === '' || $produsen === '' || $tglMasuk === '' || !is_numeric($harga) || !is_numeric($stok) || $kategori === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Form tidak valid.']; header('Location: tambah.php'); exit;
}

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO barang (nama, produsen, tahun, kode, harga, stok, kategori) VALUES (:nama, :produsen, :tahun, :kode, :harga, :stok, :kategori)");
    $stmt->execute(['nama' => $nama, 'produsen' => $produsen, 'tahun' => $tglMasuk, 'kode' => $kode, 'harga' => (float)$harga, 'stok' => (int)$stok, 'kategori' => $kategori]);
    
    $totalPengeluaran = (float) $harga * (int) $stok;
    if ($totalPengeluaran > 0) {
        $stmtTrx = $pdo->prepare("INSERT INTO transaksi (jenis, nominal, keterangan, tanggal) VALUES ('keluar', :nominal, :keterangan, :tanggal)");
        $stmtTrx->execute(['nominal' => $totalPengeluaran, 'keterangan' => "Pembelian/Stok Masuk: " . $nama . " (" . $stok . " pcs)", 'tanggal' => $tglMasuk]);
    }
    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Barang masuk berhasil disimpan.'];
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menyimpan.'];
}
header('Location: list.php'); exit;