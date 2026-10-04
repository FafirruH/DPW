<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';
csrf_verify();

$idPelanggan = $_POST['id_pelanggan'] ?? null; $idBarang = $_POST['id_barang'] ?? null; $jumlahBeli = $_POST['jumlah'] ?? 0;

if (!$idPelanggan || !$idBarang || !is_numeric($jumlahBeli) || $jumlahBeli <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Input tidak valid.']; header('Location: /Jobsheet11/pelanggan/list.php'); exit;
}

try {
    $pdo->beginTransaction();
    $stmtA = $pdo->prepare("SELECT * FROM pelanggan WHERE id = :id"); $stmtA->execute(['id' => $idPelanggan]);
    $pelanggan = $stmtA->fetch();
    $stmtB = $pdo->prepare("SELECT * FROM barang WHERE id = :id FOR UPDATE"); $stmtB->execute(['id' => $idBarang]);
    $barang = $stmtB->fetch();

    if (!$pelanggan || !$barang) throw new Exception("Data tidak ditemukan.");
    if ($barang['stok'] < $jumlahBeli) throw new Exception("Stok tidak mencukupi.");

    $stokBaru = (int) $barang['stok'] - (int) $jumlahBeli;
    $stmtUpdate = $pdo->prepare("UPDATE barang SET stok = :stok WHERE id = :id");
    $stmtUpdate->execute(['stok' => $stokBaru, 'id' => $idBarang]);

    $totalHarga = (float) $barang['harga'] * (int) $jumlahBeli;
    $stmtTrx = $pdo->prepare("INSERT INTO transaksi (jenis, nominal, keterangan, tanggal) VALUES ('masuk', :nominal, :keterangan, CURRENT_DATE)");
    $stmtTrx->execute(['nominal' => $totalHarga, 'keterangan' => "Penjualan ke " . $pelanggan['nama'] . ": " . $barang['nama'] . " (" . $jumlahBeli . " pcs)"]);
    
    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pembelian berhasil!'];
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => $e->getMessage()];
}
header('Location: /Jobsheet11/pelanggan/list.php'); exit;