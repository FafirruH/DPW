<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID pelanggan tidak valid.'];
    header('Location: list.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $stmtA = $pdo->prepare("SELECT nama FROM pelanggan WHERE id = :id");
    $stmtA->execute(['id' => (int) $id]);
    $pelanggan = $stmtA->fetch(PDO::FETCH_ASSOC);

    if ($pelanggan) {
        $stmtDelTrx = $pdo->prepare("DELETE FROM transaksi WHERE keterangan LIKE :ket");
        $stmtDelTrx->execute(['ket' => 'Penjualan ke ' . $pelanggan['nama'] . '%']);

        $stmtDelPelanggan = $pdo->prepare("DELETE FROM pelanggan WHERE id = :id");
        $stmtDelPelanggan->execute(['id' => (int) $id]);
    }

    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pelanggan dan riwayat transaksinya berhasil dihapus. Total penghasilan telah diperbarui.'];
} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus pelanggan: ' . $e->getMessage()];
}

header('Location: list.php');
exit;