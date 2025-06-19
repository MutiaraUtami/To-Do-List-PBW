<?php
session_start();
include '../protect/proteksi.php';
include '../component/nav.php';
require '../koneksi/database_connection.php';

$id = $_GET['id'] ?? 0;

// Ambil data jadwal berdasarkan ID dan milik user saat ini
$stmt = $conn->prepare("SELECT * FROM weekly_schedule WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$schedule = $result->fetch_assoc();

if (!$schedule) {
    echo "<div class='alert alert-danger'>Jadwal tidak ditemukan atau bukan milik Anda.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Jadwal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../global.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container py-5">
  <div class="glass-card p-4 mx-auto" style="max-width: 600px;">
    <h2 class="text-neon mb-4"><i class="bi bi-pencil-square"></i> Edit Jadwal Harian</h2>
    
    <form method="POST" action="proses_edit_schedule.php">
      <input type="hidden" name="id" value="<?= $schedule['id']; ?>">

      <div class="mb-3">
        <label class="form-label">Hari</label>
        <select name="day_of_week" class="form-select bg-dark text-light border-info" required>
          <?php
          $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
          foreach ($days as $day) {
              $selected = ($schedule['day_of_week'] === $day) ? 'selected' : '';
              echo "<option value=\"$day\" $selected>$day</option>";
          }
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Jam Mulai</label>
        <input type="time" name="start_time" class="form-control bg-dark text-light border-info" value="<?= $schedule['start_time']; ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Jam Selesai</label>
        <input type="time" name="end_time" class="form-control bg-dark text-light border-info" value="<?= $schedule['end_time']; ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Aktivitas</label>
        <input type="text" name="activity" class="form-control bg-dark text-light border-info" value="<?= htmlspecialchars($schedule['activity'] ?? '', ENT_QUOTES); ?>" required>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <a href="weekly_schedule.php" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-cyber">
          <i class="bi bi-save"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
