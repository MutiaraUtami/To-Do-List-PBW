<!DOCTYPE html>
<html>
<head>
    <title>Daftar Baru</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
   <h2>Masuk Pengguna</h2>
   <?php if (isset($_GET['message'])): ?>
       <div class="alert alert-info"><?= htmlspecialchars($_GET['message']) ?></div>
   <?php endif; ?>
   <form method="post" action="proses_register.php">
        <div class="mb-3">
           <label>Username:</label>
           <input type="text" id="username" name="username" class="form-control" required>
       </div>
       <div class="mb-3">
           <label>Password:</label>
           <input type="password" id="password" name="password" class="form-control" required>
       </div>
       <button type="submit" class="btn btn-primary">Masuk</button>
   </form>
   <p class="mt-3">Belum punya akun? <a href="..\register\form_register.php">Daftar di sini</a></p>
</body>
</html>