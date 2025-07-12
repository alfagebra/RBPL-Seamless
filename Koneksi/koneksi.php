<?php
$host = "localhost";
$user = "root";
$pass = ""; // sesuaikan jika pakai XAMPP
$db   = "seamless"; // pastikan DB sudah ada

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
