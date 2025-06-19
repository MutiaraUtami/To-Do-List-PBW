<?php
session_start();
session_unset();
session_destroy();
header("Location: ../login/form_login.php?message=" . urlencode("Anda telah logout."));
exit;
?>
