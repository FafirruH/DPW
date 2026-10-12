<?php
session_start();
$pageTitle = 'Beranda - SIMPUS-Mini';
$buku = $_SESSION['buku'] ?? [];
$anggota = $_SESSION['anggota'] ?? [];
$sedangDipinjam = 0;
include __DIR__ . '/includes/header.php';
?>

<main class="container my-4">
    <section class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="card-title">Selamat Datang di Sistem Perpustakaan Mini</h2>
            <p class="card-text mb-0">Sistem informasi perpustakaan untuk melihat koleksi buku dan mengelola data
                anggota.</p>
        </div>
    </section>

    <section class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="card-title mb-3">Ringkasan</h2>
            <div class="row g-3 text-center">
                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3">
                        <h3 class="h6 text-secondary">Total Buku</h3>
                        <p class="fs-2 fw-bold mb-0"><?= count($buku) ?></p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3">
                        <h3 class="h6 text-secondary">Total Anggota</h3>
                        <p class="fs-2 fw-bold mb-0"><?= count($anggota) ?></p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3">
                        <h3 class="h6 text-secondary">Sedang Dipinjam</h3>
                        <p class="fs-2 fw-bold mb-0"><?= $sedangDipinjam ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>