<?php                
require '..\koneksi\database_connection.php'; 

$display_query = "SELECT id, title, deadline, status FROM tasks";             
$results = mysqli_query($con, $display_query);   
$count = mysqli_num_rows($results);  

if ($count > 0) {
    $data_arr = array();
    $i = 0;

    while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {    
        $data_arr[$i]['event_id'] = $data_row['id'];
        $data_arr[$i]['title'] = $data_row['title'];
        $data_arr[$i]['start'] = date("Y-m-d", strtotime($data_row['deadline']));
        $data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['deadline'])); // end = same as start
        $data_arr[$i]['color'] = match($data_row['status']) {
            'done' => '#28a745',       // green
            'delayed' => '#dc3545',    // red
            default => '#ffc107',      // yellow for pending
        };
        $data_arr[$i]['url'] = '#'; // opsional, bisa arahkan ke detail task jika ada halaman detail
        $i++;
    }

    $data = array(
        'status' => true,
        'msg' => 'Successfully retrieved tasks!',
        'data' => $data_arr
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'No tasks found!'
    );
}

echo json_encode($data);
?>
