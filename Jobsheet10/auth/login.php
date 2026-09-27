<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Login Petugas";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <section class="card shadow-sm" style="border-color: var(--border-color);">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="card-title h3 fw-bold" style="color: var(--dark-chocolate);">Login Petugas</h2>
                        <p class="text-muted">Masuk untuk mengelola sistem Toko Madura</p>
                    </div>

                    <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-4 shadow-sm">
                        <?= htmlspecialchars($flash['pesan']) ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="proses_login.php">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Masukkan username..." required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Masukkan password..." required>
                        </div>
                        <div class="mb-4 form-check text-start">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-muted small fw-medium" for="remember">Ingat Saya
                                diperangkat ini</label>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-theme py-2 fs-6">Masuk Sekarang</button>
                        </div>
                        <div class="text-center">
                            <p class="text-muted small mb-0">Belum punya akun? <a href="register.php"
                                    class="text-decoration-none fw-semibold"
                                    style="color: var(--accent-terracotta);">Daftar di sini</a></p>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>