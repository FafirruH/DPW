<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$nama      = trim($_POST['nama'] ?? '');
$noPelanggan = trim($_POST['no_pelanggan'] ?? '');
$alamat    = trim($_POST['alamat'] ?? '');
$noHp      = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($noPelanggan === '') {
    $errors[] = "No. Pelanggan wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: /Jobsheet9/pelanggan/tambah.php');
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO pelanggan (nama, no_pelanggan, alamat, no_hp)
         VALUES (:nama, :no_pelanggan, :alamat, :no_hp)"
    );
    $stmt->execute([
        'nama'       => $nama,
        'no_pelanggan' => $noPelanggan,
        'alamat'     => $alamat,
        'no_hp'      => $noHp,
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pelanggan berhasil ditambahkan.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menambahkan pelanggan: ' . $e->getMessage()];
}

header('Location: /Jobsheet9/pelanggan/list.php');
exit;