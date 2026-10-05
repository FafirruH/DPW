<?php
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../list.php');
    exit;
}

try {
    $record = app_validate_record('buku', $_POST);
    $record['id'] = 'B' . bin2hex(random_bytes(5));
    $records = app_read_data('buku');
    $records[] = $record;
    app_write_data('buku', $records);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil ditambahkan.'];
} catch (InvalidArgumentException $error) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => $error->getMessage()];
    header('Location: tambah.php');
    exit;
} catch (JsonException $error) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Data buku tidak dapat diproses.'];
    header('Location: tambah.php');
    exit;
} catch (RuntimeException $error) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => $error->getMessage()];
    header('Location: tambah.php');
    exit;
}

header('Location: list.php');
exit;