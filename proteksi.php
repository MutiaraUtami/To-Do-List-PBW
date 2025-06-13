<?php
       session_start();
       if (!isset($_SESSION['login_todolist'])) {
            header("Location: login.php?message=" . urlencode("Anda harus masuk terlebih dahulu!"));
           exit;
       }
   ?>