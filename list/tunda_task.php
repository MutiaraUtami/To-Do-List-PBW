<?php
include 'database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $task_id = $_POST['task_id'];

  $sql = "UPDATE tasks SET 
            deadline = DATE_ADD(deadline, INTERVAL 2 HOUR), 
            postponed_until = NOW() 
          WHERE id = ?";
  
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $task_id);
  $stmt->execute();
}

header("Location: list_tasks.php");
exit();
?>
