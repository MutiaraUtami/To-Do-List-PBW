<?php                
require '..\koneksi\database_connection.php'; 

// Ambil data dari form (pastikan field ini dikirim via POST)
$title = $_POST['title'];
$deadline = date("Y-m-d H:i:s", strtotime($_POST['deadline']));
$reminder = date("Y-m-d H:i:s", strtotime($_POST['reminder']));
$status = $_POST['status']; 
$priority = $_POST['priority']; 
$category = $_POST['category'];
$user_id = $_POST['user_id']; 

$insert_query = "INSERT INTO tasks 
    (user_id, title, deadline, reminder, status, priority, category) 
    VALUES 
    ('$user_id', '$title', '$deadline', '$reminder', '$status', '$priority', '$category')";

if (mysqli_query($con, $insert_query)) {
    $data = array(
        'status' => true,
        'msg' => 'Task added successfully!'
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'Sorry, task not added.',
        'error' => mysqli_error($con) // untuk debugging
    );
}

echo json_encode($data);	
?>
