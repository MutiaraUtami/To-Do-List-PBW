<?php
session_start();
include '../protect/proteksi.php';
include '../component/nav.php';
require '../koneksi/database_connection.php';

$user_id = $_SESSION['id'];
$hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];

$schedule = [];
$stmt = $conn->prepare("SELECT * FROM weekly_schedule WHERE user_id = ? ORDER BY FIELD(day_of_week, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'), start_time ASC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
  $schedule[$row['day_of_week']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Jadwal Mingguan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../global.css">
  <style>
    .jadwal-card {
      background-color: #12121c;
      border: 1px solid #0dcaf0;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(13, 202, 240, 0.3);
    }
    .jadwal-item {
      background-color: #181828;
      border-bottom: 1px solid #333;
      padding: 10px 15px;
    }
    .jadwal-item:last-child {
      border-bottom: none;
    }
    .jadwal-waktu {
      font-size: 0.85rem;
      color: #888;
    }
    .jadwal-activity {
      font-weight: 500;
      color: #ffffff;
    }
    .text-neon {
      color: #0dcaf0;
      text-shadow: 0 0 8px #0dcaf0;
    }
  </style>
</head>
<body class="bg-dark text-light">

<div class="container py-5">
  <h2 class="text-neon mb-4"><i class="bi bi-calendar-week"></i> Jadwal Mingguan</h2>
  
  <div class="row">
    <?php foreach ($hari as $h): ?>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="jadwal-card p-3 h-100">
          <h5 class="text-info mb-3"><?= $h; ?></h5>
          <?php if (!empty($schedule[$h])): ?>
            <?php foreach ($schedule[$h] as $item): ?>
              <div class="jadwal-item d-flex justify-content-between align-items-start">
                <div class="me-auto">
                  <div class="jadwal-activity"><?= htmlspecialchars($item['activity_name'] ?? '', ENT_QUOTES); ?></div>
                  <div class="jadwal-waktu"><?= substr($item['start_time'], 0, 5); ?> - <?= substr($item['end_time'], 0, 5); ?></div>
                </div>
                <a href="edit_schedule.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-outline-info ms-2">
                  <i class="bi bi-pencil-square"></i>
                </a>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="jadwal-item text-secondary">Tidak ada jadwal</div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="text-end mt-4">
    <a href="add_schedule.php" class="btn btn-cyber">
      <i class="bi bi-plus-circle"></i> Tambah Jadwal
    </a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
