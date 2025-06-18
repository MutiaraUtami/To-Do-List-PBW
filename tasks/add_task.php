<?php 
include '../protect/proteksi.php';
include '../component/nav.php';
include '../koneksi/database_connection.php'; 
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Task</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4 mb-4">
    <h2 class="mb-4">Tambah Task</h2>
    <form method="POST" action="proses_addtask.php">

      <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Deadline</label>
        <input type="datetime-local" name="deadline" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Reminder</label>
        <input type="datetime-local" name="reminder" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
          <option value="pending">Pending</option>
          <option value="done">Done</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Prioritas</label>
        <select name="priority" class="form-control">
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Kategori</label>
        <input type="text" name="category" class="form-control">
      </div>

      <input type="submit" value="Tambah Task" class="btn btn-primary">
    </form>
  </div>
</body>
</html>
