<?php 
include '../protect/proteksi.php';
include '../component/nav.php';
include '../koneksi/database_connection.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Tugas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../global.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 glass-card p-4">
      <h2 class="text-neon mb-4 text-center"><i class="bi bi-plus-circle"></i> Tambah Tugas Baru</h2>

      <form method="POST" action="proses_addtask.php">
        <div class="mb-3">
          <label class="form-label">Judul</label>
          <input type="text" name="title" class="form-control bg-dark text-light border-info" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Deadline</label>
          <input type="datetime-local" name="deadline" class="form-control bg-dark text-light border-info" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Reminder</label>
          <input type="datetime-local" name="reminder" class="form-control bg-dark text-light border-info">
        </div>

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select bg-dark text-light border-info">
            <option value="pending">Pending</option>
            <option value="done">Selesai</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Prioritas</label>
          <select name="priority" class="form-select bg-dark text-light border-info">
            <option value="low">Rendah</option>
            <option value="medium">Sedang</option>
            <option value="high">Tinggi</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Kategori</label>
          <select name="category" class="form-select bg-dark text-light border-info">
            <option value="kuliah">Kuliah</option>
            <option value="kerja">Kerja</option>
            <option value="pribadi">Pribadi</option>
          </select>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-cyber">
            <i class="bi bi-save2"></i> Simpan Tugas
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
