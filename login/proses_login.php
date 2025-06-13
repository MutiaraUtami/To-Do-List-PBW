<?php
session_start();
include 'koneksi_db.php'; 

// Proses jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $username = $_POST['username'];
   $password = $_POST['password'];

   // Cek user di database
   $stmt = $conn->prepare("SELECT id, username, password FROM user WHERE username = ? AND password = ?");
   $stmt->bind_param("ss", $username,$password);
   $stmt->execute();

   $result = $stmt->get_result();

   // Validasi hasil
   if ($result->num_rows === 1) {
      
       $user = $result->fetch_assoc();
       $_SESSION['id'] = $user['id'];
       $_SESSION['username'] = $user['username'];
       $_SESSION['login_todolist'] = true;
       header("Location: index.php");
       exit;
      
   } else {
     header("Location: login.php?message=" . urlencode("Password atau username salah! Silakan coba lagi."));
   }
   $stmt->close();
}
?>