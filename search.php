<?php
session_start();
include './protect/proteksi.php';
include './component/nav.php';
require './koneksi/database_connection.php';


$user_id = $_SESSION['id'];
$query = $_GET['query'] ?? '';

$stmt = $conn->prepare("
    SELECT * FROM tasks 
    WHERE user_id = ? AND title LIKE ?
    ORDER BY deadline ASC
");
$searchParam = '%' . $query . '%';
$stmt->bind_param("is", $user_id, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Pencarian</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./global.css">
</head>
<body class="bg-dark text-light">
<div class="container py-5">
  <h3 class="text-neon mb-4">Hasil Pencarian: "<?= htmlspecialchars($query); ?>"</h3>

  <?php if ($result->num_rows > 0): ?>
    <div class="row">
      <?php while ($task = $result->fetch_assoc()): ?>
        <div class="col-md-6 col-lg-4 mb-3">
          <div class="task-card task-priority-<?= $task['priority']; ?>">
            <div class="d-flex justify-content-between">
              <div>
                <div class="task-card-title"><?= htmlspecialchars($task['title']); ?></div>
                <div class="task-card-meta">Deadline: <?= date('d M Y, H:i', strtotime($task['deadline'])); ?></div>
                <div class="task-card-meta">Status: <?= ucfirst($task['status']); ?></div>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">Tidak ada tugas ditemukan untuk kata kunci tersebut.</div>
  <?php endif; ?>
  
  <a href="index.php" class="btn btn-outline-info mt-4"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
</div>
</body>
</html>
