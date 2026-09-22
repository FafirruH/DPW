<?php
// Tangkap URL yang dibuka pengguna
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedPath = parse_url($requestUri, PHP_URL_PATH);

// Tentukan path file lokal yang dituju di repositori
$targetFile = __DIR__ . '/..' . $parsedPath;

// Jika yang dibuka adalah folder (contoh: /Jobsheet7/), cari index.php di dalam folder tersebut
if (is_dir($targetFile)) {
    $targetFile = rtrim($targetFile, '/') . '/index.php';
}

// Eksekusi file PHP jika ditemukan
if (file_exists($targetFile) && pathinfo($targetFile, PATHINFO_EXTENSION) === 'php') {
    header('Content-Type: text/html; charset=UTF-8');
    require $targetFile;
} else {
    http_response_code(404);
    echo "404 Not Found - File PHP tidak ditemukan untuk: " . htmlspecialchars($parsedPath);
}