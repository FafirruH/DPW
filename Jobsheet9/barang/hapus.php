<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID barang tidak valid.'];
    header('Location: list.php');
    exit;
}

try {
    $pdo->beginTransaction();

$stmtB = $pdo->prepare("SELECT nama FROM barang WHERE id = :id");
$stmtB->execute(['id' => (int) $id]);
$barang = $stmtB->fetch(PDO::FETCH_ASSOC);

if ($barang) {
    $stmtDelTrx = $pdo->prepare("DELETE FROM transaksi WHERE keterangan LIKE :ket");
    $stmtDelTrx->execute(['ket' => '%' . $barang['nama'] . '%']);

    $stmtDelBarang = $pdo->prepare("DELETE FROM barang WHERE id = :id");
    $stmtDelBarang->execute(['id' => (int) $id]);
}

    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Barang dan riwayat transaksinya berhasil dihapus. Total pengeluaran/penghasilan telah diperbarui.'];
} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus barang: ' . $e->getMessage()];
}

header('Location: list.php');
exit;