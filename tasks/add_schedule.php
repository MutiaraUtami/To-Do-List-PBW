<?php
session_start();
include '../protect/proteksi.php';
include '../component/nav.php';
require '../koneksi/database_connection.php';

$user_id = $_SESSION['id'];
$hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $day = $_POST['day'] ?? '';
  $start = $_POST['start_time'] ?? '';
  $end = $_POST['end_time'] ?? '';
  $category = $_POST['category'] ?? '';
  $activity = $_POST['activity'] ?? '';

  if ($day && $start && $end && $category && $activity) {
    $stmt = $conn->prepare("INSERT INTO weekly_schedule (user_id, day_of_week, start_time, end_time, category, activity_name) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $day, $start, $end, $category, $activity);
    if ($stmt->execute()) {
      header("Location: weekly_schedule.php");
      exit;
    } else {
      $error = "Gagal menyimpan jadwal: " . $stmt->error;
    }
  } else {
    $error = "Semua kolom wajib diisi.";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Jadwal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- CSS Framework & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../global.css">
</head>
<body class="bg-dark text-light">

<div class="container py-5">
  <h2 class="text-neon mb-4"><i class="bi bi-calendar-plus"></i> Tambah Jadwal Mingguan</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="POST" class="row g-3 glass-card p-4 border border-info rounded">
    <div class="col-md-4">
      <label for="day" class="form-label">Hari</label>
      <select class="form-select bg-dark text-light border-info" name="day" id="day" required>
        <option value="">-- Pilih Hari --</option>
        <?php foreach ($hari as $h): ?>
          <option value="<?= $h ?>"><?= $h ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4">
      <label for="start_time" class="form-label">Jam Mulai</label>
      <input type="time" class="form-control bg-dark text-light border-info" name="start_time" id="start_time" required>
    </div>
    <div class="col-md-4">
      <label for="end_time" class="form-label">Jam Selesai</label>
      <input type="time" class="form-control bg-dark text-light border-info" name="end_time" id="end_time" required>
    </div>
    <div class="col-md-6">
      <label for="category" class="form-label">Kategori</label>
      <select class="form-select bg-dark text-light border-info" name="category" id="category" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="kuliah">Kuliah</option>
        <option value="kerja">Kerja</option>
      </select>
    </div>
    <div class="col-md-6">
      <label for="activity" class="form-label">Aktivitas</label>
      <input type="text" class="form-control bg-dark text-light border-info" name="activity" id="activity" required>
    </div>
    <div class="col-12 d-grid mt-4">
      <button type="submit" class="btn btn-cyber"><i class="bi bi-save"></i> Simpan Jadwal</button>
    </div>
  </form>

  <div class="mt-4">
    <a href="weekly_schedule.php" class="btn btn-outline-light"><i class="bi bi-arrow-left-circle"></i> Kembali ke Jadwal</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
