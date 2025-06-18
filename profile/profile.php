<?php
include '../protect/proteksi.php';
include '../koneksi/database_connection.php';
include '../component/nav.php';

$id = $_GET['id'] ?? 0;

// Ambil user  berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <title>Profil Saya</title>
</head>
<body>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Profil Saya</h2>
    <a href="../logout/logout.php" onclick= "confirmLogout()" class="btn btn-danger">Logout</a>
  </div>
  <form method="post" action="proses_edit_profile.php">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" value="<?= $row['username']?>" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="<?= $row['email'] ?>" required>
    </div>
    <div class="mb-3">
      <label for="phone" class="form-label">Telepon</label>
      <input type="text" class="form-control" id="phone" name="phone" value="<?= $row['phone'] ?>" required>
    </div>
    <p><b>Ganti Password (opsional):</b></p>
    <div class="mb-3">
        <label for="old_password" class="form-label">Password Lama</label>
        <input type="password" class="form-control" name="old_password" placeholder="Masukkan password lama Anda">
    </div>
    <div class="mb-3">
        <label for="new_password" class="form-label">Password Baru</label>
        <input type="password" class="form-control" name="new_password" placeholder="Masukkan password baru Anda">
    </div>
    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
  </form>
</div>

<script>
function confirmLogout() {
  if (confirm("Yakin ingin logout?")) {
    window.location.href = "../logout/logout.php";
  }
}
</script>

</body>
</html>