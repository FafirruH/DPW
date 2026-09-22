<?php
$requestUri = $_SERVER['REQUEST_URI'];

$parsedUrl = parse_url($requestUri, PHP_URL_PATH);

$filePath = __DIR__ . '/..' . $parsedUrl;

if (is_dir($filePath)) {
    $filePath = rtrim($filePath, '/') . '/index.php';
}

if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
    require $filePath;
} else {
    http_response_code(404);
    echo "404 Not Found - File PHP tidak ditemukan.";
}