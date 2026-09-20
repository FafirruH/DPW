<?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5">
                <section class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4 fw-bold" style="color:#1d5b8a;">Login Petugas</h2>
                        <form action="/DPW/dashboard.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                            </div>
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn text-white" style="background-color:#1d5b8a;">Masuk</button>
                            </div>
                        </form>
                        <div class="text-center mt-3 fs-6">
                            <span class="text-secondary">Belum punya akun?</span> 
                            <a href="/DPW/registrasi.php" class="fw-medium" style="color:#1d5b8a;">Daftar di sini</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

<?php include __DIR__ . '/includes/footer.php'; ?>