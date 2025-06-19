<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Daftar Baru</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap & Custom -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../global.css" />

  <style>
    html, body {
      height: 100%;
      margin: 0;
      background-color: #0b0b0b;
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .register-card {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 2rem;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 0 20px rgba(0, 255, 255, 0.1);
    }

    .form-control {
      background-color: #111;
      border-color: #00ffff;
      color: #fff;
    }

    .form-control:focus {
      box-shadow: 0 0 5px #00ffff;
      border-color: #00ffff;
    }

    .btn-cyber {
      background: #00ffff;
      color: #000;
      font-weight: bold;
      border: none;
    }

    .btn-cyber:hover {
      background: #00cccc;
    }

    .text-neon {
      color: #00ffff;
      font-weight: bold;
      text-shadow: 0 0 5px #00ffff;
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

<div class="register-card">
  <h2 class="text-center text-neon mb-4">Registrasi Pengguna Baru</h2>

  <?php if (isset($_GET['message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= htmlspecialchars($_GET['message']) ?>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <form method="post" action="proses_register.php" onsubmit="return validatePasswords();">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" id="username" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="phone" class="form-label">No. Telepon</label>
      <input type="text" id="phone" name="phone" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" id="password" name="password" class="form-control" minlength="6" required>
    </div>

    <div class="mb-3">
      <label for="confirm_password" class="form-label">Konfirmasi Password</label>
      <input type="password" id="confirm_password" class="form-control" required>
      <div id="password-error" class="text-danger mt-2" style="display:none;">Password tidak cocok.</div>
    </div>

    <button type="submit" class="btn btn-cyber w-100 mt-3">Daftar</button>
  </form>

  <p class="text-center mt-4">
    Sudah punya akun? <a href="../login/form_login.php">Masuk di sini</a>
  </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function validatePasswords() {
    const pass = document.getElementById("password").value;
    const confirm = document.getElementById("confirm_password").value;
    const errorMsg = document.getElementById("password-error");

    if (pass !== confirm) {
      errorMsg.style.display = 'block';
      return false;
    } else {
      errorMsg.style.display = 'none';
      return true;
    }
  }
</script>

</body>
</html>
