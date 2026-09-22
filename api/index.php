<?php
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$targetFile = __DIR__ . '/..' . $requestUri;

if (file_exists($targetFile) && is_file($targetFile)) {
    $ext = pathinfo($targetFile, PATHINFO_EXTENSION);
    if ($ext === 'css') {
        header('Content-Type: text/css; charset=UTF-8');
        readfile($targetFile);
        exit;
    }
    if ($ext === 'js') {
        header('Content-Type: application/javascript; charset=UTF-8');
        readfile($targetFile);
        exit;
    }
}

if (is_dir($targetFile)) {
    $targetFile = rtrim($targetFile, '/') . '/index.php';
}

if (file_exists($targetFile) && is_file($targetFile) && pathinfo($targetFile, PATHINFO_EXTENSION) === 'php') {
    header('Content-Type: text/html; charset=UTF-8');
    require $targetFile;
    exit;
}

http_response_code(404);
echo "404 Not Found";