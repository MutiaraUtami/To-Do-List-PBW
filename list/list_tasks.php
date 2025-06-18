<?php 
include '../protect/proteksi.php';
include '../koneksi/database_connection.php';

$kategori = $_GET['kategori'] ?? '';
$userId = $_SESSION['id']; // Gunakan session yang pasti ada

if ($kategori) {
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE category = ? AND user_id = ?");
    $stmt->bind_param("si", $kategori, $userId);
} else {
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
}
$stmt->execute();
$result = $stmt->get_result();

include '../component/nav.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <title>Daftar Tugas</title>
</head>
<body>
   <div class="container mt-4">
       <h2 class="mb-4">Daftar Tugas</h2>

       <!-- Tombol Filter Kategori -->
       <form method="get" class="mb-4">
           <div class="btn-group" role="group">
               <button type="submit" name="kategori" value="" class="btn btn-outline-primary <?= $kategori == '' ? 'active' : '' ?>">Semua</button>
               <button type="submit" name="kategori" value="Sekolah" class="btn btn-outline-primary <?= $kategori == 'Sekolah' ? 'active' : '' ?>">Sekolah</button>
               <button type="submit" name="kategori" value="Kerja" class="btn btn-outline-primary <?= $kategori == 'Kerja' ? 'active' : '' ?>">Kerja</button>
               <button type="submit" name="kategori" value="Pribadi" class="btn btn-outline-primary <?= $kategori == 'Pribadi' ? 'active' : '' ?>">Pribadi</button>
           </div>
       </form>

       <!-- Tabel Daftar Tugas -->
       <table class="table table-striped">
           <thead>
               <tr>
                   <th>Judul Tugas</th>
                   <th>Kategori</th>
                   <th>Deadline</th>
                   <th>Aksi</th>
               </tr>
           </thead>
           <tbody>
<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td><?= htmlspecialchars($row['deadline']) ?></td>
        <td>
            <?php
            if ($row['priority'] == 'tinggi') echo "<span style='color:red;'>Tinggi</span>";
            elseif ($row['priority'] == 'rendah') echo "<span style='color:green;'>Rendah</span>";
            else echo "<span style='color:orange;'>Sedang</span>";
            ?>
        </td>
        <td>
            <form action="tunda_task.php" method="post" style="display:inline;">
                <input type="hidden" name="task_id" value="<?= $row['id'] ?>">
                <button type="submit">Tunda +2 Jam</button>
            </form>
        </td>
        <td>
            <form action="proses_update_status.php" method="post" class="d-inline">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                    <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="done" <?= $row['status'] === 'done' ? 'selected' : '' ?>>Done</option>
                    <option value="delayed" <?= $row['status'] === 'delayed' ? 'selected' : '' ?>>Delayed</option>
                </select>
            </form>
        </td>
        <td>
            <a href="./tasks/form_edit_task.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="./tasks/proses_hapus_task.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus tugas ini?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="4" class="text-center text-muted">Tidak ada tugas untuk kategori ini.</td>
    </tr>
<?php endif; ?>
</tbody>
       </table>
   </div>
   <!-- Modal Edit Tugas -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="./tasks/proses_edit_task.php" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Tugas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="task-id">
          <div class="mb-3">
            <label for="task-title" class="form-label">Judul</label>
            <input type="text" class="form-control" name="title" id="task-title" required>
          </div>
          <div class="mb-3">
            <label for="task-category" class="form-label">Kategori</label>
            <select class="form-select" name="category" id="task-category">
              <option value="Sekolah">Sekolah</option>
              <option value="Kerja">Kerja</option>
              <option value="Pribadi">Pribadi</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="task-deadline" class="form-label">Deadline</label>
            <input type="date" class="form-control" name="deadline" id="task-deadline">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var editModal = document.getElementById('editModal');
  editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget || event.target;
    var row = button.closest('tr');

    document.getElementById('task-id').value = row.getAttribute('data-id');
    document.getElementById('task-title').value = row.getAttribute('data-title');
    document.getElementById('task-category').value = row.getAttribute('data-category');
    document.getElementById('task-deadline').value = row.getAttribute('data-deadline');
  });
});
</script>

</body>
</html>
