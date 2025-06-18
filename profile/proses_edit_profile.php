<?php
include '../koneksi/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = $_POST['id'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];

    $old_pass = $_POST['old_password'] ?? '';
    $new_pass = $_POST['new_password'] ?? '';

    // ambil data user dulu
    $stmt = $conn->prepare("SELECT password FROM users WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "<script>alert('User tidak ditemukan'); window.location='index.php';</script>";
        exit;
    }

    $update_password = false;
    $hashed_new_pass = '';

    if (!empty($old_pass) && !empty($new_pass)) {
        if (password_verify($old_pass, $user['password'])) {
            $hashed_new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
            $update_password = true;
        } else {
            echo "<script>alert('Password lama salah!'); window.location='index.php';</script>";
            exit;
        }
    }

    if ($update_password) {
        $stmt = $conn->prepare("UPDATE users SET username=?, email=?, phone=?, password=? WHERE ID=?");
        $stmt->bind_param("ssssi", $username, $email, $phone, $hashed_new_pass, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username=?, email=?, phone=? WHERE ID=?");
        $stmt->bind_param("sssi", $username, $email, $phone, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui'); window.location='../index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data'); window.location='../index.php';</script>";
    }
}
?>
