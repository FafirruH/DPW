<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';
csrf_verify();

$nama = trim($_POST['nama'] ?? ''); $noPelanggan = trim($_POST['no_pelanggan'] ?? '');
$alamat = trim($_POST['alamat'] ?? ''); $noHp = trim($_POST['no_hp'] ?? '');

if ($nama === '' || $noPelanggan === '') { $_SESSION['flash'] = ['type' => 'error', 'pesan' => "Data wajib diisi."]; header('Location: /Jobsheet12/pelanggan/tambah.php'); exit; }

try {
    $stmt = $pdo->prepare("INSERT INTO pelanggan (nama, no_pelanggan, alamat, no_hp) VALUES (:nama, :no_pelanggan, :alamat, :no_hp)");
    $stmt->execute(['nama' => $nama, 'no_pelanggan' => $noPelanggan, 'alamat' => $alamat, 'no_hp' => $noHp]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pelanggan berhasil ditambahkan.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menambahkan.'];
}
header('Location: /Jobsheet12/pelanggan/list.php'); exit;