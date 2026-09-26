<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$idBarang    = $_POST['id_barang'] ?? null;
$jumlahKeluar = $_POST['jumlah'] ?? 0;

if (!$idBarang || !is_numeric($jumlahKeluar) || $jumlahKeluar <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Jumlah barang keluar tidak valid.'];
    header('Location: list.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT * FROM barang WHERE id = :id");
    $stmt->execute(['id' => $idBarang]);
    $barang = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$barang) {
        throw new Exception("Barang tidak ditemukan.");
    }

    if ($barang['stok'] < $jumlahKeluar) {
        throw new Exception("Stok tidak mencukupi! Stok saat ini: " . $barang['stok']);
    }

    $stokBaru = $barang['stok'] - $jumlahKeluar;
    $stmtUpdate = $pdo->prepare("UPDATE barang SET stok = :stok WHERE id = :id");
    $stmtUpdate->execute(['stok' => $stokBaru, 'id' => $idBarang]);

    $totalPenghasilan = (float) $barang['harga'] * (int) $jumlahKeluar;
    $stmtTrx = $pdo->prepare(
        "INSERT INTO transaksi (jenis, nominal, keterangan, tanggal)
         VALUES ('masuk', :nominal, :keterangan, CURRENT_DATE)"
    );
    $stmtTrx->execute([
        'nominal'    => $totalPenghasilan,
        'keterangan' => "Penjualan/Barang Keluar: " . $barang['nama'] . " (" . $jumlahKeluar . " pcs)",
    ]);

    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Barang keluar berhasil diproses & penghasilan telah dicatat.'];

} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memproses barang keluar: ' . $e->getMessage()];
}

header('Location: list.php');
exit;