<?php
include '../koneksi/database_connection.php';

$data = [];

$id = $_GET['id'] ?? 0;

$query = $koneksi->prepare("SELECT title, deadline FROM tasks WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'title' => $row['title'],
        'end' => $row['deadline']
        
    ];
}

echo json_encode($data);
?>
