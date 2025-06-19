<?php
include '../protect/proteksi.php';
include '../koneksi/database_connection.php';
include '../component/nav.php';

$id = $_GET['id'] ?? 0;

// Ambil data user
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Saya</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../global.css" rel="stylesheet" />
</head>
<body class="bg-dark text-light">

<div class="container py-5">
  <div class="card glass-card mx-auto" style="max-width: 700px;">
    <div class="card-header border-bottom border-info d-flex justify-content-between align-items-center">
      <h4 class="text-neon mb-0">👤 Profil Saya</h4>
      <form action="/logout.php" method="POST">
        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
      </form>
    </div>

    <div class="card-body">
      <form method="POST" action="proses_edit_profile.php">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <div class="mb-3">
          <label for="username" class="form-label text-info">Username</label>
          <input type="text" class="form-control bg-dark text-light border-info" id="username" name="username" value="<?= htmlspecialchars($row['username']) ?>" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label text-info">Email</label>
          <input type="email" class="form-control bg-dark text-light border-info" id="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label text-info">Telepon</label>
          <input type="text" class="form-control bg-dark text-light border-info" id="phone" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" required>
        </div>

        <hr class="border-secondary" />

        <p class="text-info"><strong>Ubah Password (opsional)</strong></p>

        <div class="mb-3">
          <label for="old_password" class="form-label">Password Lama</label>
          <input type="password" class="form-control bg-dark text-light border-info" name="old_password" placeholder="Masukkan password lama">
        </div>

        <div class="mb-3">
          <label for="new_password" class="form-label">Password Baru</label>
          <input type="password" class="form-control bg-dark text-light border-info" name="new_password" placeholder="Masukkan password baru">
        </div>

        <button type="submit" class="btn btn-cyber w-100 mt-3">Simpan Perubahan</button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
