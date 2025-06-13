<!DOCTYPE html>
<html>
<head>
    <title>Daftar Baru</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
   <h2>Daftar Baru Pengguna</h2>
   <?php if (isset($_GET['message'])): ?>
       <div class="alert alert-info"><?= htmlspecialchars($_GET['message']) ?></div>
   <?php endif; ?>
   <form method="post" action="proses_register.php">
        <div class="mb-3">
           <label>Nama:</label>
           <input type="text" id="nama" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
           <label>No. Telepon:</label>
           <input type="text" id="telepon" name="telepon" class="form-control" required>
       </div>
        <div class="mb-3">
           <label>Email:</label>
           <input type="email" id="email" name="email" class="form-control" required>
       </div>
       <div class="mb-3">
           <label>Username:</label>
           <input type="text" id="username" name="username" class="form-control" required>
       </div>
       <div class="mb-3">
           <label>Password:</label>
           <input type="password" id="password" name="password" class="form-control" required>
       </div>
       <button type="submit" class="btn btn-primary">Daftar</button>
   </form>
   <p class="mt-3">Sudah punya akun? <a href="../login/form_login.php">Masuk di sini</a></p>
</body>
</html>