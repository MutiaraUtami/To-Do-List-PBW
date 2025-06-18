<?php                
require '../koneksi/database_connection.php'; 
$event_name = $_POST['title'];
$event_start_date = date("y-m-d", strtotime($_POST['created_at'])); 
$event_end_date = date("y-m-d", strtotime($_POST['deadline'])); 
			
$insert_query = "insert into tasks(title,created_at,deadline) values ('".$event_name."','".$event_start_date."','".$event_end_date."')";             
if(mysqli_query($con, $insert_query))
{
	$data = array(
                'status' => true,
                'msg' => 'Event added successfully!'
            );
}
else
{
	$data = array(
                'status' => false,
                'msg' => 'Sorry, Event not added.'				
            );
}
echo json_encode($data);	
?>
