<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPUS — Modul Jobsheet Praktikum</title>
    <!-- CDN Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #5c3d2e;       /* Cokelat Mocha utama */
            --primary-hover: #43281c;       /* Dark Espresso saat hover */
            --dark-chocolate: #2c1d11;      /* Cokelat pekat header */
            --bg-cream: #f8f4e9;            /* Background krem hangat */
            --border-color: #e6ddc4;        /* Border lembut */
        }

        body {
            background-color: var(--bg-cream);
            color: #3d2b1f;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: var(--dark-chocolate) !important;
        }

        .jobsheet-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }

        .jobsheet-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(44, 29, 17, 0.12);
            border-color: var(--primary-color);
            color: inherit;
        }

        .jobsheet-badge {
            background-color: var(--primary-color);
            color: #ffffff;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <header class="navbar navbar-dark shadow-sm">
        <div class="container py-1">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
                <span>Desain Dan Pemrograman WEB</span>
            </a>
            <span class="badge bg-light text-dark font-monospace">Modul Jobsheet Praktikum</span>
        </div>
    </header>

    <main class="container my-5 flex-grow-1">
        <div class="text-center mb-4">
            <h1 class="h2 fw-bold" style="color: var(--dark-chocolate);">Daftar Modul Jobsheet</h1>
            <p class="text-muted">Pilih modul praktikum di bawah ini untuk melihat progres dan pengerjaan aplikasi SIMPUS.</p>
        </div>

        <div class="row g-3 g-md-4">
            <?php
            $jobsheets = [
                1 => ['judul' => 'Jobsheet 1', 'desc' => ''],
                2 => ['judul' => 'Jobsheet 2', 'desc' => ''],
                3 => ['judul' => 'Jobsheet 3', 'desc' => ''],
                4 => ['judul' => 'Jobsheet 4', 'desc' => ''],
                5 => ['judul' => 'Jobsheet 5', 'desc' => ''],
                6 => ['judul' => 'Jobsheet 6', 'desc' => ''],
                7 => ['judul' => 'Jobsheet 7', 'desc' => ''],
                8 => ['judul' => 'Jobsheet 8', 'desc' => '']
            ];

            foreach ($jobsheets as $i => $js): 
                $folder = "Jobsheet" . $i;
            ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="./<?= $folder ?>/" class="jobsheet-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="jobsheet-badge"><?= htmlspecialchars($js['judul']) ?></span>
                            <small class="text-muted">/<?= htmlspecialchars($folder) ?></small>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--dark-chocolate);"><?= htmlspecialchars($js['judul']) ?></h5>
                        <p class="text-secondary small mb-3"><?= htmlspecialchars($js['desc']) ?></p>
                        <div class="d-flex align-items-center text-primary fw-semibold small">
                            <span>Buka Modul</span> &rarr;
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="text-center py-3 border-top bg-white mt-auto">
        <div class="container">
            <p class="mb-0 text-secondary small">&copy; 2026 Desain Dan Pemrograman WEB — Fafirru Hadzami</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>