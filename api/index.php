<?php
// Tangkap URI permintaan
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedUrl = parse_url($requestUri, PHP_URL_PATH);

// Tentukan path file lokal
$filePath = __DIR__ . '/..' . $parsedUrl;

// Jika mengarah ke folder, cari index.php di dalamnya
if (is_dir($filePath)) {
    $filePath = rtrim($filePath, '/') . '/index.php';
}

// Eksekusi file PHP jika ada
if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
    header('Content-Type: text/html; charset=UTF-8');
    require $filePath;
} else {
    http_response_code(404);
    echo "404 - Halaman tidak ditemukan.";
}