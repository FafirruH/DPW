<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();

setcookie('remember_user', '', time() - 3600, "/");

header('Location: login.php');
exit;