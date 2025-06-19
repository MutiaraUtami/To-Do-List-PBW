<?php
include '../koneksi/database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id']) && is_numeric($_POST['task_id'])) {
    $task_id = (int)$_POST['task_id'];

    // Update hanya deadline
    $sql = "UPDATE tasks 
            SET deadline = DATE_ADD(deadline, INTERVAL 2 HOUR) 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $task_id);
        if ($stmt->execute()) {
            header("Location: list_tasks.php?status=success");
        } else {
            header("Location: list_tasks.php?status=fail");
        }
        $stmt->close();
    } else {
        header("Location: list_tasks.php?status=error");
    }
} else {
    header("Location: list_tasks.php?status=invalid");
}
exit();
?>
