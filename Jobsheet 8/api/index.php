<?php
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($requestUri === '/' || $requestUri === '/index.php') {
    require __DIR__ . '/../index.php';
    exit;
}

$file = __DIR__ . '/..' . $requestUri;

if (file_exists($file) && is_file($file)) {
    require $file;
    exit;
}

http_response_code(404);
echo "404 Not Found";