<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$idPelanggan  = $_POST['id_pelanggan'] ?? null;
$idBarang   = $_POST['id_barang'] ?? null;
$jumlahBeli = $_POST['jumlah'] ?? 0;

if (!$idPelanggan || !$idBarang || !is_numeric($jumlahBeli) || $jumlahBeli <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Mohon pilih barang dan masukan jumlah pembelian yang valid.'];
    header('Location: /Jobsheet8/pelanggan/list.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $stmtA = $pdo->prepare("SELECT * FROM pelanggan WHERE id = :id");
    $stmtA->execute(['id' => $idPelanggan]);
    $pelanggan = $stmtA->fetch(PDO::FETCH_ASSOC);

    $stmtB = $pdo->prepare("SELECT * FROM barang WHERE id = :id FOR UPDATE");
    $stmtB->execute(['id' => $idBarang]);
    $barang = $stmtB->fetch(PDO::FETCH_ASSOC);

    if (!$pelanggan) {
        throw new Exception("Data pelanggan tidak ditemukan.");
    }

    if (!$barang) {
        throw new Exception("Barang yang dipilih tidak ditemukan.");
    }

    if ($barang['stok'] < $jumlahBeli) {
        throw new Exception("Stok barang '" . $barang['nama'] . "' tidak mencukupi! Stok tersisa saat ini: " . $barang['stok'] . " pcs.");
    }

    $stokBaru = (int) $barang['stok'] - (int) $jumlahBeli;
    $stmtUpdate = $pdo->prepare("UPDATE barang SET stok = :stok WHERE id = :id");
    $stmtUpdate->execute(['stok' => $stokBaru, 'id' => $idBarang]);

    $totalHarga = (float) $barang['harga'] * (int) $jumlahBeli;
    $stmtTrx = $pdo->prepare(
        "INSERT INTO transaksi (jenis, nominal, keterangan, tanggal)
         VALUES ('masuk', :nominal, :keterangan, CURRENT_DATE)"
    );
    $stmtTrx->execute([
        'nominal'    => $totalHarga,
        'keterangan' => "Penjualan ke " . $pelanggan['nama'] . ": " . $barang['nama'] . " (" . $jumlahBeli . " pcs)",
    ]);

    $pdo->commit();
    $_SESSION['flash'] = [
        'type' => 'success', 
        'pesan' => 'Pembelian berhasil! Stok ' . $barang['nama'] . ' berkurang ' . $jumlahBeli . ' pcs. Total bayar: Rp ' . number_format($totalHarga, 0, ',', '.')
    ];

} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memproses transaksi: ' . $e->getMessage()];
}

header('Location: /Jobsheet8/pelanggan/list.php');
exit;