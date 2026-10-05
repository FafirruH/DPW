<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Beranda - SIMPUS-Mini';
$buku = app_read_data('buku');
$anggota = app_read_data('anggota');
$jumlahBuku = array_sum(array_map(static fn(array $item): int => (int) ($item['stok'] ?? 0), $buku));
include __DIR__ . '/includes/header.php';
?>

    <main class="container my-4">
        <section class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title text-theme">Selamat Datang di SIMPUS-Mini</h2>
                <p class="card-text mb-0">Sistem informasi perpustakaan untuk melihat koleksi buku dan mengelola data anggota.</p>
            </div>
        </section>

        <section class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title mb-3 text-theme">Ringkasan</h2>
                <div class="row g-3 text-center">
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded-3" style="background-color:#eef4fa;">
                            <h3 class="h6 text-secondary">Total Buku</h3>
                            <p class="fs-2 fw-bold mb-0 text-theme"><?= count($buku) ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded-3" style="background-color:#eef4fa;">
                            <h3 class="h6 text-secondary">Total Anggota</h3>
                            <p class="fs-2 fw-bold mb-0 text-theme"><?= count($anggota) ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded-3" style="background-color:#eef4fa;">
                            <h3 class="h6 text-secondary">Total Stok Buku</h3>
                            <p class="fs-2 fw-bold mb-0 text-theme"><?= $jumlahBuku ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php include __DIR__ . '/includes/footer.php'; ?>