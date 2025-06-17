<?php
session_start();
include '../koneksi/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password_input = $_POST['password'];

    // Ambil data user berdasarkan username
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password_input, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['login_todolist'] = true;

            header("Location: ../index.php");
            exit;
        } else {
            header("Location: login.php?message=" . urlencode("Password salah!"));
            exit;
        }
    } else {
        header("Location: login.php?message=" . urlencode("Username tidak ditemukan!"));
        exit;
    }

    $stmt->close();
}
?>
