<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (isset($_SESSION['login_attempts'][$username]) && $_SESSION['login_attempts'][$username] >= 3) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Akun terkunci sementara karena Anda gagal login 3 kali berturut-turut.'];
    header('Location: login.php');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        unset($_SESSION['login_attempts'][$username]);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['role']    = $user['role'];
        if (isset($_POST['remember'])) {
    setcookie('remember_user', $user['id'], time() + (86400 * 30), "/");
}
        header('Location: ../index.php');
        exit;
    }

    if (!isset($_SESSION['login_attempts'][$username])) {
        $_SESSION['login_attempts'][$username] = 1;
    } else {
        $_SESSION['login_attempts'][$username]++;
    }

    $sisa = 3 - $_SESSION['login_attempts'][$username];
    if ($sisa > 0) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => "Username atau password salah! Sisa percobaan: $sisa kali."];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => "Maksimal percobaan tercapai! Akun Anda kini diblokir dari perangkat ini."];
    }

} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Terjadi kesalahan sistem.'];
}

header('Location: login.php');
exit;