<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login_todolist'])) {
    header("Location: ./login/form_login.php?message=" . urlencode("Anda harus masuk terlebih dahulu!"));
    exit;
}
?>
