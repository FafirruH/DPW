<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$_SESSION['anggota'] ??= [];
$action = (string) ($_POST['aksi'] ?? '');

if ($action === 'hapus') {
    $id = trim((string) ($_POST['id'] ?? ''));
    $existingCount = count($_SESSION['anggota']);
    $_SESSION['anggota'] = array_values(array_filter(
        $_SESSION['anggota'],
        static fn(array $member): bool => (string) ($member['id'] ?? '') !== $id
    ));
    $_SESSION['flash'] = count($_SESSION['anggota']) < $existingCount
        ? ['type' => 'success', 'pesan' => 'Anggota berhasil dihapus.']
        : ['type' => 'danger', 'pesan' => 'Data anggota tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$stringField = static function (string $key): string {
    $value = $_POST[$key] ?? '';
    return is_scalar($value) ? trim((string) $value) : '';
};
$nama = $stringField('nama');
$noAnggota = $stringField('no_anggota');
$alamat = $stringField('alamat');
$noHp = $stringField('no_hp');
$errors = [];

if ($nama === '') {
    $errors[] = 'Nama wajib diisi.';
}
if ($noAnggota === '') {
    $errors[] = 'Nomor anggota wajib diisi.';
}
foreach ($_SESSION['anggota'] as $member) {
    if ((string) ($member['no_anggota'] ?? '') === $noAnggota) {
        $errors[] = 'Nomor anggota sudah terdaftar.';
        break;
    }
}

if ($errors !== []) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$_SESSION['anggota'][] = [
    'id' => 'A' . bin2hex(random_bytes(5)),
    'no_anggota' => $noAnggota,
    'nama' => $nama,
    'alamat' => $alamat,
    'no_hp' => $noHp,
];
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];

header('Location: list.php');
exit;