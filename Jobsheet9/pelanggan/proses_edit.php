<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id          = $_POST['id'] ?? null;
$nama        = trim($_POST['nama'] ?? '');
$noPelanggan = trim($_POST['no_pelanggan'] ?? '');
$alamat      = trim($_POST['alamat'] ?? '');
$noHp        = trim($_POST['no_hp'] ?? '');

if (!$id || !is_numeric($id)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID pelanggan tidak valid.'];
    header('Location: /Jobsheet9/pelanggan/list.php');
    exit;
}

$errors = [];
if ($nama === '') $errors[] = "Nama wajib diisi.";
if ($noPelanggan === '') $errors[] = "No. Pelanggan wajib diisi.";

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: /Jobsheet9/pelanggan/edit.php?id=' . $id);
    exit;
}

try {
    $stmt = $pdo->prepare("
        UPDATE pelanggan 
        SET nama = :nama, 
            no_pelanggan = :no_pelanggan, 
            alamat = :alamat, 
            no_hp = :no_hp 
        WHERE id = :id
    ");

    $stmt->execute([
        'nama'         => $nama,
        'no_pelanggan' => $noPelanggan,
        'alamat'       => $alamat,
        'no_hp'        => $noHp,
        'id'           => (int) $id,
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data pelanggan berhasil diperbarui.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui pelanggan: ' . $e->getMessage()];
}

header('Location: /Jobsheet9/pelanggan/list.php');
exit;