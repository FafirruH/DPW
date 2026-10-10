<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$_SESSION['buku'] ??= [];
$action = (string) ($_POST['aksi'] ?? '');
$id = trim((string) ($_POST['id'] ?? ''));

if ($action === 'hapus') {
    $existingCount = count($_SESSION['buku']);
    $_SESSION['buku'] = array_values(array_filter(
        $_SESSION['buku'],
        static fn(array $book): bool => (string) ($book['id'] ?? '') !== $id
    ));
    $_SESSION['flash'] = count($_SESSION['buku']) < $existingCount
        ? ['type' => 'success', 'pesan' => 'Buku berhasil dihapus.']
        : ['type' => 'danger', 'pesan' => 'Data buku tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$stringField = static function (string $key): string {
    $value = $_POST[$key] ?? '';
    return is_scalar($value) ? trim((string) $value) : '';
};
$judul = $stringField('judul');
$pengarang = $stringField('pengarang');
$tahun = filter_var($_POST['tahun'] ?? null, FILTER_VALIDATE_INT);
$isbn = $stringField('isbn');
$stok = filter_var($_POST['stok'] ?? null, FILTER_VALIDATE_INT);
$kategori = $stringField('kategori');
$errors = [];

if ($judul === '') {
    $errors[] = 'Judul wajib diisi.';
}
if ($pengarang === '') {
    $errors[] = 'Pengarang wajib diisi.';
}
if ($tahun === false || $tahun < 1900 || $tahun > (int) date('Y')) {
    $errors[] = 'Tahun terbit harus di antara 1900 dan tahun ini.';
}
if ($stok === false || $stok < 0) {
    $errors[] = 'Stok harus berupa angka nol atau lebih.';
}
if ($isbn !== '' && !preg_match('/^[0-9-]+$/', $isbn)) {
    $errors[] = 'ISBN hanya boleh berisi angka dan tanda hubung (-).';
}
if (!in_array($kategori, ['fiksi', 'non-fiksi', 'referensi'], true)) {
    $errors[] = 'Kategori buku tidak valid.';
}

if ($errors !== []) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php' . ($id === '' ? '' : '?edit=' . rawurlencode($id)));
    exit;
}

$record = [
    'id' => $id !== '' ? $id : 'B' . bin2hex(random_bytes(5)),
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => $tahun,
    'isbn' => $isbn,
    'stok' => $stok,
    'kategori' => $kategori,
];
$recordIndex = null;
if ($id !== '') {
    foreach ($_SESSION['buku'] as $index => $book) {
        if ((string) ($book['id'] ?? '') === $id) {
            $recordIndex = $index;
            break;
        }
    }
    if ($recordIndex === null) {
        $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Data buku tidak ditemukan.'];
        header('Location: list.php');
        exit;
    }
    $_SESSION['buku'][$recordIndex] = $record;
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil diperbarui.'];
} else {
    $_SESSION['buku'][] = $record;
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil ditambahkan.'];
}

header('Location: list.php');
exit;
