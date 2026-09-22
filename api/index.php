<?php
// Mengambil path URL yang diakses browser
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Jika mengakses halaman root/landing page
if ($requestUri === '/' || $requestUri === '/index.html') {
    require __DIR__ . '/../index.html';
    exit;
}

// Menentukan lokasi file fisik di dalam proyek
$file = __DIR__ . '/..' . $requestUri;

// Jika mengarah ke direktori (misal /Jobsheet8/), cari index.php di dalamnya
if (is_dir($file)) {
    $file = rtrim($file, '/') . '/index.php';
}

// Jika file PHP ditemukan, set header HTML dan jalankan file
if (file_exists($file) && is_file($file)) {
    header('Content-Type: text/html; charset=UTF-8');
    require $file;
    exit;
}

// Jika tidak ditemukan, kembalikan 404
http_response_code(404);
echo "404 Not Found - File tidak ditemukan: " . htmlspecialchars($requestUri);