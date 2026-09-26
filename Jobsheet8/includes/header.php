<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' - Toko Madura' : 'Toko Madura' ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        :root {
            --primary-color: #5c3d2e;
            --primary-hover: #43281c;
            --dark-chocolate: #2c1d11;
            --bg-cream: #f8f4e9;
            --bg-card: #ffffff;
            --accent-terracotta: #b85042;
            --text-main: #3d2b1f;
            --text-muted: #786452;
            --border-color: #e6ddc4;
            --card-shadow: 0 8px 20px -4px rgba(92, 61, 46, 0.06);
            --border-radius: 14px;
        }

        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: var(--bg-cream) !important;
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            margin: 0;
            line-height: 1.6;
        }

        main.container {
            flex: 1 0 auto;
        }

        .navbar {
            background-color: var(--dark-chocolate) !important;
            box-shadow: 0 4px 12px rgba(44, 29, 17, 0.15);
            padding: 0.85rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: -0.02em;
            color: #f8f4e9 !important;
        }

        .nav-link {
            font-weight: 500;
            color: #d0c0b0 !important;
            padding: 0.5rem 1rem !important;
            transition: all 0.2s ease;
            border-radius: 8px;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background-color: rgba(248, 244, 233, 0.12);
        }

        .card {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            background-color: var(--bg-card);
        }

        .card-title {
            color: var(--dark-chocolate);
        }

        .stat-card {
            border-radius: var(--border-radius);
            padding: 1.35rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 1px solid var(--border-color);
            transition: transform 0.2s ease;
        }

        .form-label {
            color: var(--text-main);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background-color: #fdfbf7;
            color: var(--text-main);
            padding: 0.65rem 0.9rem;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            background-color: #ffffff;
            color: var(--dark-chocolate);
            box-shadow: 0 0 0 3px rgba(92, 61, 46, 0.15);
        }

        .table-responsive {
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background-color: #ffffff;
        }

        .table thead th {
            background-color: #f4eee0;
            color: var(--dark-chocolate);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody td {
            padding: 0.95rem 1rem;
            vertical-align: middle;
            font-size: 0.925rem;
            color: var(--text-main);
            border-bottom: 1px solid #f2ebe0;
        }

        .btn {
            border-radius: 10px;
            padding: 0.55rem 1.1rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .btn-theme {
            background-color: var(--primary-color) !important;
            color: #ffffff !important;
            border: none;
        }

        .btn-theme:hover {
            background-color: var(--primary-hover) !important;
            color: #ffffff !important;
        }

        footer {
            background-color: #ffffff;
            border-top: 1px solid var(--border-color);
            text-align: center;
            padding: 1.2rem 0;
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="/Jobsheet8/index.php">
                <span>Toko Madura</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <nav class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/Jobsheet8/index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Jobsheet8/barang/list.php">Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Jobsheet8/pelanggan/list.php">Pelanggan</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>