<?php
include '../protect/proteksi.php';
include '../koneksi/database_connection.php';
include '../component/nav.php';

$kategori = $_GET['kategori'] ?? '';
$user_id = $_SESSION['id'];

// Query
if ($kategori) {
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE category = ? AND user_id = ?");
    $stmt->bind_param("si", $kategori, $user_id);
} else {
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar Tugas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../global.css">
</head>
<body class="bg-dark text-light">

<div class="container py-5">
  <h2 class="text-neon mb-4">Daftar Tugas</h2>

  <!-- Filter Kategori -->
  <form method="get" class="mb-4">
    <div class="btn-group" role="group">
      <button type="submit" name="kategori" value="" class="btn btn-outline-info <?= $kategori == '' ? 'active' : '' ?>">Semua</button>
      <button type="submit" name="kategori" value="Sekolah" class="btn btn-outline-info <?= $kategori == 'Sekolah' ? 'active' : '' ?>">Sekolah</button>
      <button type="submit" name="kategori" value="Kerja" class="btn btn-outline-info <?= $kategori == 'Kerja' ? 'active' : '' ?>">Kerja</button>
      <button type="submit" name="kategori" value="Pribadi" class="btn btn-outline-info <?= $kategori == 'Pribadi' ? 'active' : '' ?>">Pribadi</button>
    </div>
  </form>

  <!-- List Tugas -->
  <?php if ($result->num_rows > 0): ?>
    <div class="row g-3">
      <?php while ($task = $result->fetch_assoc()): ?>
        <div class="col-md-6">
          <div class="card glass-card h-100 shadow-sm border border-secondary">
            <div class="card-body">
              <h5 class="card-title text-neon"><?= htmlspecialchars($task['title']) ?></h5>
              <p class="mb-1">Kategori: <span class="badge bg-info"><?= htmlspecialchars($task['category']) ?></span></p>
              <p class="mb-1">Deadline: <span class="text-warning"><?= htmlspecialchars($task['deadline']) ?></span></p>
              <p class="mb-1">
                Prioritas:
                <?php
                switch ($task['priority']) {
                  case 'high': echo '<span class="badge bg-danger">Tinggi</span>'; break;
                  case 'low': echo '<span class="badge bg-success">Rendah</span>'; break;
                  default: echo '<span class="badge bg-warning text-dark">Sedang</span>';
                }
                ?>
              </p>
              <p class="mb-1">
                Status:
                <form action="/tasks/proses_update_status.php" method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?= $task['id'] ?>">
                  <select name="status" onchange="this.form.submit()" class="form-select form-select-sm bg-dark text-light border-info">
                    <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="done" <?= $task['status'] === 'done' ? 'selected' : '' ?>>Done</option>
                    <option value="delayed" <?= $task['status'] === 'delayed' ? 'selected' : '' ?>>Delayed</option>
                  </select>
                </form>
              </p>
              <form action="./tasks/tunda_task.php" method="post" class="d-inline">
                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                <button class="btn btn-outline-warning btn-sm mt-2">Tunda +2 Jam</button>
              </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
              <button
                class="btn btn-sm btn-outline-info"
                data-bs-toggle="modal"
                data-bs-target="#editModal"
                data-id="<?= $task['id'] ?>"
                data-title="<?= htmlspecialchars($task['title'], ENT_QUOTES) ?>"
                data-category="<?= $task['category'] ?>"
                data-deadline="<?= date('Y-m-d', strtotime($task['deadline'])) ?>"
              >Edit</button>

              <a href="./tasks/proses_hapus_task.php?id=<?= $task['id'] ?>"
                onclick="return confirm('Yakin ingin menghapus tugas ini?')"
                class="btn btn-sm btn-outline-danger">Hapus</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-secondary text-center mt-4">
      Tidak ada tugas ditemukan.
    </div>
  <?php endif; ?>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/tasks/proses_edit_task.php" method="POST" class="modal-content glass-card">
      <div class="modal-header">
        <h5 class=
