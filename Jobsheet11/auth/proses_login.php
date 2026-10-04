<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (isset($_SESSION['login_attempts'][$username]) && $_SESSION['login_attempts'][$username] >= 3) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Akun terkunci sementara karena gagal login 3 kali.'];
    header('Location: login.php'); exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        unset($_SESSION['login_attempts'][$username]);
        session_regenerate_id(true); // Proteksi Session Fixation

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['role']    = $user['role'];
        if (isset($_POST['remember'])) {
            setcookie('remember_user', $user['id'], time() + (86400 * 30), "/");
        }
        header('Location: ../index.php'); exit;
    }

    $_SESSION['login_attempts'][$username] = ($_SESSION['login_attempts'][$username] ?? 0) + 1;
    $sisa = 3 - $_SESSION['login_attempts'][$username];
    if ($sisa > 0) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => "Username atau password salah! Sisa percobaan: $sisa kali."];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => "Maksimal percobaan tercapai! Akun diblokir sementara."];
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Terjadi kesalahan sistem.'];
}
header('Location: login.php'); exit;