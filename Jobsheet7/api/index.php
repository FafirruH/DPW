<?php
// Tangkap path dari request URL
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedPath = parse_url($requestUri, PHP_URL_PATH);

// Tentukan lokasi file lokal
$targetFile = __DIR__ . '/..' . $parsedPath;

// Jika direktori, arahkan ke index.php di dalamnya
if (is_dir($targetFile)) {
    $targetFile = rtrim($targetFile, '/') . '/index.php';
}

// Eksekusi file PHP jika ada
if (file_exists($targetFile) && pathinfo($targetFile, PATHINFO_EXTENSION) === 'php') {
    require $targetFile;
} else {
    http_response_code(404);
    echo "404 - Halaman PHP Tidak Ditemukan";
}