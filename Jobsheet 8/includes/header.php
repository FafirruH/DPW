<?php
session_start();
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
    <title>SIMPUS | Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark" style="background-color:#1d5b8a;">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="index.php">SIMPUS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <nav class="collapse navbar-collapse" id="navMenu">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="/DPW/index.php">Beranda</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/DPW/buku/list.php">Daftar Buku</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/DPW/buku/tambah.php">Tambah Buku</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/DPW/anggota/list.php">Daftar Anggota</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/DPW/anggota/tambah.php">Tambah Anggota</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/DPW/login.php">Login</a>
        </li>
    </ul>
</nav>
        </div>
    </header>