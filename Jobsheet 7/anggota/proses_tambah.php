<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /DPW/anggota/list.php');
    exit;
}

$nama = htmlspecialchars(trim($_POST['nama'] ?? ''), ENT_QUOTES, 'UTF-8');
$noAnggota = htmlspecialchars(trim($_POST['no_anggota'] ?? ''), ENT_QUOTES, 'UTF-8');
$alamat = htmlspecialchars(trim($_POST['alamat'] ?? ''), ENT_QUOTES, 'UTF-8');
$noHp = htmlspecialchars(trim($_POST['no_hp'] ?? ''), ENT_QUOTES, 'UTF-8');

$errors = [];

if ($nama === '') $errors[] = "Nama wajib diisi.";
if ($noAnggota === '') $errors[] = "No. Anggota wajib diisi.";

if ($noHp !== '' && !preg_match('/^\+?[0-9]{10,14}$/', $noHp)) {
    $errors[] = "Format No. HP tidak valid (hanya angka/kode negara + dan 10-14 digit).";
}

if (isset($_SESSION['anggota'])) {
    foreach ($_SESSION['anggota'] as $item) {
        if ($item['no_anggota'] === $noAnggota) {
            $errors[] = "No. Anggota sudah terdaftar.";
            break;
        }
    }
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => implode('<br>', $errors)];
    header('Location: /DPW/anggota/tambah.php');
    exit;
}

if (!isset($_SESSION['anggota'])) $_SESSION['anggota'] = [];

$_SESSION['anggota'][] = [
    'nama' => $nama,
    'no_anggota' => $noAnggota,
    'alamat' => $alamat,
    'no_hp' => $noHp,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: /DPW/anggota/list.php');
exit;