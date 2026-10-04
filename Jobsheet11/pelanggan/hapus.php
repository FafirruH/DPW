<?php
require __DIR__ . '/../includes/auth.php';  
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Akses ditolak: Hanya Admin.'];
    header('Location: list.php'); exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: list.php'); exit; }
csrf_verify();

$id = $_POST['id'] ?? null;
if (!$id || !is_numeric($id)) { header('Location: /Jobsheet11/pelanggan/list.php'); exit; }

try {
    $pdo->beginTransaction();
    $stmtA = $pdo->prepare("SELECT nama FROM pelanggan WHERE id = :id"); $stmtA->execute(['id' => (int) $id]);
    $pelanggan = $stmtA->fetch();
    if ($pelanggan) {
        $stmtDelTrx = $pdo->prepare("DELETE FROM transaksi WHERE keterangan LIKE :ket");
        $stmtDelTrx->execute(['ket' => 'Penjualan ke ' . $pelanggan['nama'] . '%']);
        $stmtDelPelanggan = $pdo->prepare("DELETE FROM pelanggan WHERE id = :id");
        $stmtDelPelanggan->execute(['id' => (int) $id]);
    }
    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pelanggan berhasil dihapus.'];
} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus.'];
}
header('Location: /Jobsheet11/pelanggan/list.php'); exit;