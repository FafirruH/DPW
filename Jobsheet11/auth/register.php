<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (isset($_SESSION['user_id'])) { header('Location: ../index.php'); exit; }

$page_title = "Registrasi Petugas";
include __DIR__ . '/../includes/header.php';
$flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']);
?>
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <section class="card shadow-sm" style="border-color: var(--border-color);">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="card-title h3 fw-bold" style="color: var(--dark-chocolate);">Daftar Petugas Baru</h2>
                    </div>
                    <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-4 shadow-sm">
                        <?= e($flash['pesan']) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="proses_register.php">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="6"
                                required>
                        </div>
                        <div class="d-grid mb-3"><button type="submit" class="btn btn-theme py-2">Daftar Akun</button>
                        </div>
                        <div class="text-center">
                            <p class="text-muted small mb-0">Sudah punya akun? <a href="login.php">Login di sini</a></p>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>