<?php
include '../koneksi/database_connection.php';

$id = $_GET['id'] ?? 0;

$title = $_POST['title'];
$deadline = $_POST['deadline'];
$reminder = $_POST['reminder'];
$status = $_POST['status'];
$priority = $_POST['priority'];
$category = $_POST['category'];

$stmt = $conn->prepare("INSERT INTO tasks (user_id, title, deadline, reminder, status, priority, category, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("issssss", $user_id, $title, $deadline, $reminder, $status, $priority, $category);

if ($stmt->execute()) {
    echo "Task berhasil ditambahkan. <a href='/index.php'>Lihat Kalender</a>";
} else {
    echo "Gagal menambahkan task: " . $stmt->error;
}
?>
