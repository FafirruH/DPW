<?php
session_start();
$pageTitle = 'Beranda - SIMPUS-Mini';
$buku = $_SESSION['buku'] ?? [];
$anggota = $_SESSION['anggota'] ?? [];
$sedangDipinjam = 0;
include __DIR__ . '/includes/header.php';
?>

    <main class="container my-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title text-theme">Selamat Datang di Sistem Perpustakaan Mini</h2>
                <p class="card-text mb-0">Sistem informasi perpustakaan untuk melihat koleksi buku dan mengelola data anggota.</p>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title mb-3 text-theme">Ringkasan</h2>
                <div class="row g-3 text-center">
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded-3 bg-light">
                            <h3 class="h6 text-secondary">Total Buku</h3>
                            <p class="fs-2 fw-bold mb-0 text-theme"><?= count($buku) ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded-3 bg-light">
                            <h3 class="h6 text-secondary">Total Anggota</h3>
                            <p class="fs-2 fw-bold mb-0 text-theme"><?= count($anggota) ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded-3 bg-light">
                            <h3 class="h6 text-secondary">Sedang Dipinjam</h3>
                            <p class="fs-2 fw-bold mb-0 text-theme"><?= $sedangDipinjam ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include __DIR__ . '/includes/footer.php'; ?>