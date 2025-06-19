<?php
session_start();
require '../koneksi/database_connection.php';

$user_id = $_SESSION['id'];
$id = $_POST['id'] ?? null;
$title = $_POST['title'];
$deadline = $_POST['deadline'];
$priority = $_POST['priority'];
$category = $_POST['category'];

// Jika ID ada, lakukan update
if ($id) {
    $stmt = $conn->prepare("UPDATE tasks SET title = ?, deadline = ?, priority = ?, category = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssssii", $title, $deadline, $priority, $category, $id, $user_id);
} else {
    // Jika tidak ada ID, berarti tambah
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, deadline, priority, category, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("issss", $user_id, $title, $deadline, $priority, $category);
}

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
?>
