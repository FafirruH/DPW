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
    $stmtDelBarang = $pdo->prepare("DELETE FROM barang WHERE id = :id");
    $stmtDelBarang->execute(['id' => (int) $id]);
    
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Barang berhasil dihapus. Riwayat kas tetap dipertahankan.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus barang.'];
}
header('Location: list.php'); exit;