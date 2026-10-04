<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($nama === '' || $username === '' || strlen($password) < 6) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Form tidak valid.'];
    header('Location: register.php'); exit;
}

try {
    $cek = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $cek->execute(['username' => $username]);
    if ($cek->fetch()) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username sudah digunakan.'];
        header('Location: register.php'); exit;
    }

    $stmt = $pdo->prepare("INSERT INTO users (nama, username, password, role) VALUES (:nama, :username, :password, 'admin')");
    $stmt->execute(['nama' => $nama, 'username' => $username, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
    
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Registrasi berhasil! Silakan login.'];
    header('Location: login.php'); exit;
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mendaftar.'];
    header('Location: register.php'); exit;
}