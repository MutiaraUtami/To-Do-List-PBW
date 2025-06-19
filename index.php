<?php
session_start();
include './protect/proteksi.php';
include './component/nav.php';

require './koneksi/database_connection.php';
$user_id = $_SESSION['id'];
$result = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY deadline ASC");
$result->bind_param("i", $user_id);
$result->execute();
$tasks = $result->get_result();
$kategori = $_GET['kategori'] ?? '';
$prioritas = $_GET['prioritas'] ?? '';

$query = "SELECT *, 
    CASE priority 
        WHEN 'low' THEN 1 
        WHEN 'medium' THEN 2 
        WHEN 'high' THEN 3 
        ELSE 4 
    END as priority_order 
    FROM tasks 
    WHERE user_id = ?";

$params = [$user_id];
$types = "i";
$status = $_GET['status'] ?? '';

if ($kategori) {
    $query .= " AND category = ?";
    $types .= "s";
    $params[] = $kategori;
}

if ($prioritas) {
    $query .= " AND priority = ?";
    $types .= "s";
    $params[] = $prioritas;
}

if ($status) {
    $query .= " AND status = ?";
    $types .= "s";
    $params[] = $status;
}

$query .= " ORDER BY priority_order ASC, deadline ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$tasks = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Tugas Saya</title>

  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="global.css" />
</head>
<body class="bg-dark text-light">

<div class="container py-5">
  <div class="d-flex justify-content-between mb-4 align-items-center">
    <h2 class="text-neon">Tugas Saya</h2>
		<a href="./tasks/add_task.php" class="btn btn-cyber">
		<i class="bi bi-plus-lg"></i> Tambah Tugas
		</a>

  </div>

  <!-- Filter Form -->
<form method="GET" class="row g-3 mb-4">
  <div class="col-md-3">
    <select name="kategori" class="form-select bg-dark text-light border-info">
      <option value="">Semua Kategori</option>
      <option value="kerja" <?= ($_GET['kategori'] ?? '') === 'kerja' ? 'selected' : '' ?>>Kerja</option>
      <option value="kuliah" <?= ($_GET['kategori'] ?? '') === 'kuliah' ? 'selected' : '' ?>>Kuliah</option>
      <option value="pribadi" <?= ($_GET['kategori'] ?? '') === 'pribadi' ? 'selected' : '' ?>>Pribadi</option>
    </select>
  </div>
  <div class="col-md-3">
    <select name="prioritas" class="form-select bg-dark text-light border-info">
      <option value="">Semua Prioritas</option>
      <option value="low" <?= ($_GET['prioritas'] ?? '') === 'low' ? 'selected' : '' ?>>Rendah</option>
      <option value="medium" <?= ($_GET['prioritas'] ?? '') === 'medium' ? 'selected' : '' ?>>Sedang</option>
      <option value="high" <?= ($_GET['prioritas'] ?? '') === 'high' ? 'selected' : '' ?>>Tinggi</option>
    </select>
  </div>
  <div class="col-md-3">
    <select name="status" class="form-select bg-dark text-light border-info">
      <option value="">Semua Status</option>
      <option value="pending" <?= ($_GET['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
      <option value="done" <?= ($_GET['status'] ?? '') === 'done' ? 'selected' : '' ?>>Selesai</option>
    </select>
  </div>
  <div class="col-md-3 d-grid">
    <button type="submit" class="btn btn-outline-info">
      <i class="bi bi-funnel"></i> Terapkan Filter
    </button>
  </div>
</form>

<div class="row">
  <?php foreach ($tasks as $task): ?>
    <div class="col-md-6 col-lg-4">
      <div class="task-card task-priority-<?= $task['priority']; ?>"
		data-id="<?= $task['id']; ?>"
		data-title="<?= htmlspecialchars($task['title'], ENT_QUOTES); ?>"
		data-deadline="<?= date('Y-m-d\TH:i', strtotime($task['deadline'])); ?>"
		data-priority="<?= $task['priority']; ?>"
		data-category="<?= $task['category']; ?>">
        <div class="d-flex justify-content-between">
          <div>
            <div class="task-card-title"><?= htmlspecialchars($task['title']); ?></div>
            <div class="task-card-meta">Deadline: <?= date('d M Y, H:i', strtotime($task['deadline'])); ?></div>
            <div class="task-card-meta">Kategori: <?= htmlspecialchars($task['category']); ?></div>
            <div class="task-card-meta">Status: <?= ucfirst($task['status']); ?></div>
          </div>
          <div>
            <button class="task-action-btn" onclick="openEditModal(<?= $task['id']; ?>)">
              <i class="bi bi-pencil-square"></i>
            </button>
            <button class="task-action-btn" onclick="deleteTask(<?= $task['id']; ?>)">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

</div>

<!-- Modal: Tambah & Edit tugas -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content bg-dark text-light glass-card">
      <div class="modal-header border-secondary">
        <h5 class="modal-title" id="modalTitle">Tambah/Edit Tugas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="formTask">
      <div class="modal-body">
          <input type="hidden" id="task_id" name="id">
          <div class="mb-3">
            <label for="task_title" class="form-label">Judul</label>
            <input type="text" class="form-control bg-dark text-light border-info" id="task_title" name="title" required>
          </div>
          <div class="mb-3">
            <label for="task_deadline" class="form-label">Deadline</label>
            <input type="datetime-local" class="form-control bg-dark text-light border-info" id="task_deadline" name="deadline" required>
          </div>
          <div class="mb-3">
            <label for="task_priority" class="form-label">Prioritas</label>
            <select class="form-select bg-dark text-light border-info" id="task_priority" name="priority">
              <option value="high">Tinggi</option>
              <option value="medium">Sedang</option>
              <option value="low">Rendah</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="task_category" class="form-label">Kategori</label>
            <select class="form-select bg-dark text-light border-info" id="task_category" name="category">
              <option value="kerja">Kerja</option>
              <option value="kuliah">Kuliah</option>
              <option value="pribadi">Pribadi</option>
            </select>
          </div>
      </div>
      <div class="modal-footer border-secondary">
        <button type="button" class="btn btn-danger me-auto" id="btnDelete">Hapus</button>
        <button type="submit" class="btn btn-cyber" id="btnSave">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const modal = new bootstrap.Modal(document.getElementById('modalForm'));
  const form = document.getElementById('formTask');
  const deleteBtn = document.getElementById('btnDelete');

  form.addEventListener('submit', e => {
    e.preventDefault();
    const data = new FormData(form);
    fetch('./tasks/save_task.php', { method:'POST', body:data })
      .then(r => r.json()).then(resp => location.reload());
  });

  deleteBtn.addEventListener('click', () => {
    if (confirm('Yakin ingin menghapus tugas ini?')) {
      const id = form.task_id.value;
      fetch('./tasks/delete_task.php', {
        method:'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id='+id
      }).then(r => r.json()).then(resp => location.reload());
    }
  });

	document.querySelectorAll('.task-card').forEach(card => {
	 card.addEventListener('click', () => {
		modal.show();
		document.getElementById('modalTitle').textContent = 'Edit Tugas';
		document.getElementById('btnDelete').style.display = 'inline-block';
		document.getElementById('btnSave').textContent = 'Update';

		document.getElementById('task_id').value = card.dataset.id;
		document.getElementById('task_title').value = card.dataset.title;
		document.getElementById('task_deadline').value = card.dataset.deadline;
		document.getElementById('task_priority').value = card.dataset.priority;
		document.getElementById('task_category').value = card.dataset.category;
	});
	});
    });

  document.querySelector('button[data-bs-target="#modalAdd"]').addEventListener('click', () => {
    form.reset();
    document.getElementById('modalTitle').textContent = 'Tambah Tugas';
    deleteBtn.style.display = 'none';
    document.getElementById('task_id').value = '';
    document.getElementById('btnSave').textContent = 'Tambah';
  });
</script>
</body>
</html>
