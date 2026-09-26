<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id       = $_POST['id'] ?? null;
$nama     = trim($_POST['nama'] ?? '');
$produsen = trim($_POST['produsen'] ?? '');
$tglMasuk = $_POST['tgl_masuk'] ?? '';
$kode     = trim($_POST['kode'] ?? '');
$harga    = $_POST['harga'] ?? 0;
$stok     = $_POST['stok'] ?? 0;
$kategori = trim($_POST['kategori'] ?? '');

if (!$id || !is_numeric($id)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID barang tidak valid.'];
    header('Location: list.php');
    exit;
}

$errors = [];
if ($nama === '') $errors[] = "Nama barang wajib diisi.";
if ($produsen === '') $errors[] = "Produsen / Merek wajib diisi.";
if ($tglMasuk === '') $errors[] = "Tanggal barang masuk wajib diisi.";
if (!is_numeric($harga) || $harga < 0) $errors[] = "Harga barang tidak boleh negatif.";
if (!is_numeric($stok) || $stok < 0) $errors[] = "Stok tidak boleh negatif.";
if ($kategori === '') $errors[] = "Kategori barang wajib dipilih.";

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . $id);
    exit;
}

try {
    $stmt = $pdo->prepare("
        UPDATE barang 
        SET nama = :nama, 
            produsen = :produsen, 
            tahun = :tahun, 
            kode = :kode, 
            harga = :harga, 
            stok = :stok, 
            kategori = :kategori 
        WHERE id = :id
    ");

    $stmt->execute([
        'nama'     => $nama,
        'produsen' => $produsen,
        'tahun'    => $tglMasuk,
        'kode'     => $kode,
        'harga'    => (float) $harga,
        'stok'     => (int) $stok,
        'kategori' => $kategori,
        'id'       => (int) $id,
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data barang berhasil diperbarui.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui data barang: ' . $e->getMessage()];
}

header('Location: list.php');
exit;