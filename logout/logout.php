<?php
session_start();
session_unset();  // Hapus semua variabel sesi
session_destroy(); // Hancurkan sesi

// Redirect ke login dengan pesan
header("Location: ../login/form_login.php?message=Anda telah berhasil logout");
exit;
?>
