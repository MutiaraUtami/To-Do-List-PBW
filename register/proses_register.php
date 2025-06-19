<?php
include '../koneksi/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($phone) || empty($email) || empty($username) || empty($password)) {
        header("Location: form_register.php?message=" . urlencode("Semua field wajib diisi."));
        exit;
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: form_register.php?message=" . urlencode("Format email tidak valid."));
        exit;
    }

    // Validasi minimal panjang password
    if (strlen($password) < 6) {
        header("Location: form_register.php?message=" . urlencode("Password minimal 6 karakter."));
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek username/email unik
    $cek = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $cek->bind_param("ss", $email, $username);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $cek->close();
        header("Location: form_register.php?message=" . urlencode("Email atau username sudah digunakan."));
        exit;
    }
    $cek->close();

    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO users (phone, email, username, password) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $phone, $email, $username, $hashed_password);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: ../login/form_login.php?message=" . urlencode("Berhasil mendaftar! Silakan login."));
            exit;
        } else {
            $stmt->close();
            $conn->close();
            header("Location: form_register.php?message=" . urlencode("Gagal menyimpan data. Silakan coba lagi."));
            exit;
        }
    } else {
        $conn->close();
        header("Location: form_register.php?message=" . urlencode("Kesalahan sistem. Gagal menyiapkan SQL."));
        exit;
    }
}
?>
