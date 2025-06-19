<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - ToDoList</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <!-- Custom Global CSS -->
  <link rel="stylesheet" href="../global.css"/>
  <style>
    body {
      background: #0f0f0f;
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .login-card {
      backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 2rem;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.2);
    }

    .form-control,
    .btn {
      border-radius: 0.6rem;
    }

    .btn-login {
      background-color: #00ffff;
      color: #000;
      font-weight: bold;
    }

    .text-neon {
      color: #00ffff;
      font-weight: 700;
      text-shadow: 0 0 5px #00ffff, 0 0 10px #00ffff;
    }

    a {
      color: #00ffff;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="login-card text-light">
    <h2 class="mb-4 text-neon text-center">Masuk ke ToDoList</h2>

    <?php if (isset($_GET['message'])): ?>
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_GET['message']) ?>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form method="POST" action="proses_login.php" autocomplete="off">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" id="username" name="username" class="form-control bg-dark text-light border-info" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control bg-dark text-light border-info" required>
      </div>

      <button type="submit" class="btn btn-login w-100 mt-2">Masuk</button>
    </form>

    <p class="text-center mt-3">
      Belum punya akun? <a href="../register/form_register.php">Daftar di sini</a>
    </p>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
