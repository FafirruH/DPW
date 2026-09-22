<?php
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedPath = parse_url($requestUri, PHP_URL_PATH);

$targetFile = __DIR__ . '/..' . $parsedPath;

if (is_dir($targetFile)) {
    $targetFile = rtrim($targetFile, '/') . '/index.php';
}

if (file_exists($targetFile) && pathinfo($targetFile, PATHINFO_EXTENSION) === 'php') {
    header('Content-Type: text/html; charset=UTF-8');
    require $targetFile;
} else {
    http_response_code(404);
    echo "404 - Halaman PHP tidak ditemukan.";
}