<?php
require_once __DIR__ . '/functions.php';
$base = app_base_url();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle ?? 'SIMPUS-Mini', ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>assets/css/style.css">
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-theme">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>index.php">SIMPUS-Mini</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <nav class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>buku/list.php">Daftar Buku</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>anggota/list.php">Daftar Anggota</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <?php app_render_flash(); ?>