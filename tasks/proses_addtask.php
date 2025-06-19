<?php
session_start(); // Tambahkan jika belum ada
require '../koneksi/database_connection.php';

$user_id = $_SESSION['id'];

$title = $_POST['title'];
$deadline = $_POST['deadline'];
$reminder = $_POST['reminder'];
$status = $_POST['status'];
$priority = $_POST['priority'];
$category = $_POST['category'];

$stmt = $conn->prepare("INSERT INTO tasks (user_id, title, deadline, reminder, status, priority, category, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("issssss", $user_id, $title, $deadline, $reminder, $status, $priority, $category);

if ($stmt->execute()) {
    header("Location: ../index.php");
    exit;
} else {
    echo "Gagal menambahkan task: " . $stmt->error;
}
?>
