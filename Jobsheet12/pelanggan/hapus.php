<?php
require __DIR__ . '/../includes/auth.php';  
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SESSION['role'] !== 'admin') { header('Location: list.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: list.php'); exit; }
csrf_verify();

$id = $_POST['id'] ?? null;
if (!$id || !is_numeric($id)) { header('Location: /Jobsheet11/pelanggan/list.php'); exit; }

try {
    $stmtDelPelanggan = $pdo->prepare("DELETE FROM pelanggan WHERE id = :id");
    $stmtDelPelanggan->execute(['id' => (int) $id]);
    
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pelanggan berhasil dihapus. Histori transaksi tetap dipertahankan sebagai anonim.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus pelanggan.'];
}
header('Location: /Jobsheet11/pelanggan/list.php'); exit;