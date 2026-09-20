<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /DPW/buku/list.php');
    exit;
}

$judul = htmlspecialchars(trim($_POST['judul'] ?? ''), ENT_QUOTES, 'UTF-8');
$pengarang = htmlspecialchars(trim($_POST['pengarang'] ?? ''), ENT_QUOTES, 'UTF-8');
$tahun = filter_var($_POST['tahun'] ?? '', FILTER_VALIDATE_INT);
$isbn = htmlspecialchars(trim($_POST['isbn'] ?? ''), ENT_QUOTES, 'UTF-8');
$stok = filter_var($_POST['stok'] ?? '', FILTER_VALIDATE_INT);
$kategori = htmlspecialchars(trim($_POST['kategori'] ?? ''), ENT_QUOTES, 'UTF-8');

$errors = [];

if ($judul === '') $errors[] = "Judul buku wajib diisi.";
if ($pengarang === '') $errors[] = "Pengarang wajib diisi.";

if ($tahun === false || $tahun < 1900 || $tahun > 2026) {
    $errors[] = "Tahun terbit harus di antara 1900 dan 2026.";
}

if ($stok === false || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}

if ($isbn !== '' && !preg_match('/^[0-9-]+$/', $isbn)) {
    $errors[] = "ISBN hanya boleh berisi angka dan tanda hubung (-).";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => implode('<br>', $errors)];
    header('Location: /DPW/buku/tambah.php');
    exit;
}

if (!isset($_SESSION['buku'])) $_SESSION['buku'] = [];

$_SESSION['buku'][] = [
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => $tahun,
    'isbn' => $isbn,
    'stok' => $stok,
    'kategori' => $kategori
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil ditambahkan.'];
header('Location: /DPW/buku/list.php');
exit;