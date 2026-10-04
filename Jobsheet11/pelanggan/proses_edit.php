<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';
csrf_verify();

$id = $_POST['id'] ?? null; $nama = trim($_POST['nama'] ?? ''); $noPelanggan = trim($_POST['no_pelanggan'] ?? '');
$alamat = trim($_POST['alamat'] ?? ''); $noHp = trim($_POST['no_hp'] ?? '');

if (!$id || !is_numeric($id)) { header('Location: /Jobsheet11/pelanggan/list.php'); exit; }
if ($nama === '' || $noPelanggan === '') { $_SESSION['flash'] = ['type' => 'error', 'pesan' => "Data wajib diisi."]; header('Location: /Jobsheet11/pelanggan/edit.php?id=' . $id); exit; }

try {
    $stmt = $pdo->prepare("UPDATE pelanggan SET nama = :nama, no_pelanggan = :no_pelanggan, alamat = :alamat, no_hp = :no_hp WHERE id = :id");
    $stmt->execute(['nama' => $nama, 'no_pelanggan' => $noPelanggan, 'alamat' => $alamat, 'no_hp' => $noHp, 'id' => (int) $id]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data pelanggan berhasil diperbarui.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui.'];
}
header('Location: /Jobsheet11/pelanggan/list.php'); exit;