<?php
$host     = getenv('PGHOST') ?: '127.0.0.1';
$port     = getenv('PGPORT') ?: '5432';
$dbname   = getenv('PGDATABASE') ?: 'simpus';
$user     = getenv('PGUSER') ?: 'postgres';
$password = getenv('PGPASSWORD') ?: 'postgres';

try {
    if (getenv('PGHOST')) {
        $endpoint = explode('.', $host)[0];
        
        $dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require;options='endpoint={$endpoint}'";
    } else {
        $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    }

    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}