<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/csrf.php';

$sudahLogin = isset($_SESSION['user_id']);

$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($page_title) ? e($page_title) . ' - Toko Madura' : 'Toko Madura' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
</head>

<body>
    <header class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $base ?>index.php">
                <span>Toko Madura</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <nav class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= $base ?>index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $base ?>barang/list.php">Barang</a></li>
                    <?php if ($sudahLogin): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= $base ?>pelanggan/list.php">Pelanggan</a></li>
                    <!-- TAMBAHAN MENU BARU -->
                    <li class="nav-item"><a class="nav-link text-warning fw-semibold"
                            href="<?= $base ?>transaksi/riwayat.php">Riwayat Transaksi</a></li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center gap-3 ms-auto mt-3 mt-lg-0">
                    <?php if ($sudahLogin): ?>
                    <span class="text-light fw-medium small">Halo, <?= e($_SESSION['nama']) ?></span>
                    <a href="<?= $base ?>auth/logout.php" class="btn btn-outline-light btn-sm px-3">Logout</a>
                    <?php else: ?>
                    <a href="<?= $base ?>auth/login.php" class="btn btn-theme btn-sm px-4"
                        style="background-color: var(--accent-terracotta);">Login</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>