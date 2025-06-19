<?php
session_start();
require '../koneksi/database_connection.php';

// Validasi sesi user
if (!isset($_SESSION['id'])) {
    die("Akses ditolak.");
}

$user_id = $_SESSION['id'];
$id = $_POST['id'] ?? null;
$day_of_week = $_POST['day_of_week'] ?? '';
$start_time = $_POST['start_time'] ?? '';
$end_time = $_POST['end_time'] ?? '';
$activity = $_POST['activity'] ?? '';

// Validasi input
if (!$id || !$day_of_week || !$start_time || !$end_time || !$activity) {
    die("Data tidak lengkap.");
}

// Perbarui data ke database
$stmt = $conn->prepare("
    UPDATE weekly_schedule 
    SET day_of_week = ?, start_time = ?, end_time = ?, activity = ? 
    WHERE id = ? AND user_id = ?
");
$stmt->bind_param("ssssii", $day_of_week, $start_time, $end_time, $activity, $id, $user_id);

if ($stmt->execute()) {
    header("Location: weekly_schedule.php?edit=success");
    exit;
} else {
    echo "<div class='alert alert-danger'>Gagal mengupdate jadwal: " . htmlspecialchars($stmt->error, ENT_QUOTES) . "</div>";
}
