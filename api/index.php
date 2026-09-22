<?php
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($requestUri === '/' || $requestUri === '/index.html') {
    require __DIR__ . '/../index.html';
    exit;
}

$file = __DIR__ . '/..' . $requestUri;

if (is_dir($file)) {
    $file = rtrim($file, '/') . '/index.php';
}

if (file_exists($file) && is_file($file)) {
    header('Content-Type: text/html; charset=UTF-8');
    require $file;
    exit;
}

http_response_code(404);
echo "404 Not Found - File tidak ditemukan: " . htmlspecialchars($requestUri);