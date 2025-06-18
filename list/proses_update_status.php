<?php
include '../koneksi/database_connection.php';
include '../protect/proteksi.php';


if (isset($_POST['id'], $_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $userId = $_SESSION['user_id'];

    // validasi nilai status
    $allowed_status = ['pending', 'done', 'delayed'];
    if (in_array($status, $allowed_status)) {
        $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $status, $id, $userId);
        $stmt->execute();
    }
}

header('Location: list_tasks.php?id=<?php echo $_SESSION['user_id']; ?');
exit;
?>