<?php
include 'koneksi_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $nama = $_POST['nama'];
   $telepon = $_POST['telepon'];
   $email = $_POST['email'];
   $username = $_POST['username'];
   $password = $_POST['password'];

   $stmt = $conn->prepare("INSERT INTO user (nama, telepon, email, username, password) VALUES (?,?,?,?,?)");
   $stmt->bind_param("sisss", $nama, $katasandi, $email, $username, $password);

   
   if ($stmt->execute()) {
       echo "<script>
           alert('Berhasil daftar!');
           window.location.href = 'index.php';
       </script>";
   } else {
       echo "<script>
           alert('Gagal mendaftar: " . addslashes($stmt->error) . "');
           window.location.href = 'index.php';
       </script>";
   }
}
?>