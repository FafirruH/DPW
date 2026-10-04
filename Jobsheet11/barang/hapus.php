<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SESSION['role'] !== 'admin') { header('Location: list.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: list.php'); exit; }
csrf_verify();

$id = $_POST['id'] ?? null;
if (!$id || !is_numeric($id)) { header('Location: list.php'); exit; }

try {
    $pdo->beginTransaction();
    $stmtB = $pdo->prepare("SELECT nama FROM barang WHERE id = :id"); $stmtB->execute(['id' => (int) $id]);
    $barang = $stmtB->fetch();
    if ($barang) {
        $stmtDelTrx = $pdo->prepare("DELETE FROM transaksi WHERE keterangan LIKE :ket");
        $stmtDelTrx->execute(['ket' => '%' . $barang['nama'] . '%']);
        $stmtDelBarang = $pdo->prepare("DELETE FROM barang WHERE id = :id");
        $stmtDelBarang->execute(['id' => (int) $id]);
    }
    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Barang berhasil dihapus.'];
} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus.'];
}
header('Location: list.php'); exit;