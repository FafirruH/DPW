<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';
csrf_verify();

$id = $_POST['id'] ?? null;
$nama = trim($_POST['nama'] ?? ''); $produsen = trim($_POST['produsen'] ?? ''); $tglMasuk = $_POST['tgl_masuk'] ?? '';
$kode = trim($_POST['kode'] ?? ''); $harga = $_POST['harga'] ?? 0; $stok = $_POST['stok'] ?? 0; $kategori = trim($_POST['kategori'] ?? '');

if (!$id || !is_numeric($id)) { header('Location: list.php'); exit; }
if ($nama === '' || $produsen === '' || $tglMasuk === '' || !is_numeric($harga) || !is_numeric($stok) || $kategori === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Form tidak valid.']; header('Location: edit.php?id=' . $id); exit;
}

try {
    $stmt = $pdo->prepare("UPDATE barang SET nama = :nama, produsen = :produsen, tahun = :tahun, kode = :kode, harga = :harga, stok = :stok, kategori = :kategori WHERE id = :id");
    $stmt->execute(['nama' => $nama, 'produsen' => $produsen, 'tahun' => $tglMasuk, 'kode' => $kode, 'harga' => (float)$harga, 'stok' => (int)$stok, 'kategori' => $kategori, 'id' => (int)$id]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data barang berhasil diperbarui.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui.'];
}
header('Location: list.php'); exit;