<?php
session_start();
$pageTitle = "Dashboard";
include 'component/head.php';
include 'component/nav.php';
?>

<body>
  <div class="container mt-5">
    <h1 class="text-neon">Selamat datang kembali, <?= $_SESSION['username']; ?>!</h1>
    <!-- Konten lainnya -->
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
