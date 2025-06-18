<?php 
include './protect/proteksi.php';
include './component/nav.php';
include './koneksi/database_connection.php'; 
?>

<!DOCTYPE html>
<html>
<head>
  <title>Kalender Tugas</title>
  <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css' rel='stylesheet' />
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-4">Kalender Tugas</h2>
    <a href="./tasks/add_task.php" class="btn btn-primary mb-3">Tambah Tugas</a>
</div>
  <div id='calendar'></div>
  </div>

  <script>
    $(document).ready(function() {
      $('#calendar').fullCalendar({
        events: './tasks/load_tasks.php'
      });
    });
  </script>
</body>
</html>
