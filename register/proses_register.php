<?php
include '../koneksi/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username atau email sudah terdaftar
    $cek = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $cek->bind_param("ss", $email, $username);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo "<script>
            alert('Email atau Username sudah terdaftar!');
            window.location.href = 'form_register.php';
        </script>";
        $cek->close();
        exit;
    }
    $cek->close();

    // Simpan data pengguna baru
    $stmt = $conn->prepare("INSERT INTO users (phone, email, username, password) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $phone, $email, $username, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>
                alert('Berhasil daftar!');
                window.location.href = '../login/form_login.php';
            </script>";
        } else {
            echo "<script>
                alert('Gagal mendaftar: " . addslashes($stmt->error) . "');
                window.location.href = 'form_register.php';
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('Gagal menyiapkan pernyataan SQL.');
            window.location.href = 'form_register.php';
        </script>";
    }

    $conn->close();
}
?>
