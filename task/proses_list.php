<?php
   include '../koneksi/database_connection.php'; // Koneksi database

   // ambil kategori dari URL (jika ada)
    $kategori = $_GET['kategori'] ?? '';

    // ambil data tugas dari database
    if ($kategori) {
        $stmt = $conn->prepare("SELECT * FROM tasks WHERE kategori = ? AND id = ?");
        $stmt->bind_param("si", $kategori, $_SESSION['user_id']);
    } else {
        $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
    }
    $stmt->execute();
    $result = $stmt->get_result();
?>
