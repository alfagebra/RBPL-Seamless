<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
    header("Location: ../login/login.php");
    exit;
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $nama_produk = $_POST['nama_produk'];
    $jumlah = $_POST['jumlah'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $catatan = $_POST['catatan'];

    $stmt = $conn->prepare("INSERT INTO produksi_requests (user_id, nama_produk, jumlah, tanggal_mulai, catatan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isiss", $user_id, $nama_produk, $jumlah, $tanggal_mulai, $catatan);

    if ($stmt->execute()) {
        echo "<script>alert('Pengajuan produksi berhasil dikirim.'); window.location.href='invoice.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan data.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Form Produksi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
    }
    .container {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 280px;
      background-color: #3B0000;
      color: white;
      padding: 30px 20px;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .sidebar h2 {
      font-family: 'Pacifico', cursive;
      font-size: 28px;
      margin-bottom: 20px;
    }
    .profile-img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
    }
    .profile-img img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
    }
    .user-id, .user-name {
      font-size: 13px;
      text-align: center;
      margin-bottom: 5px;
    }
    .user-name {
      margin-bottom: 30px;
      font-size: 15px;
    }
    .menu {
      display: flex;
      flex-direction: column;
      gap: 15px;
      width: 100%;
    }
    .menu-item {
      padding: 10px 15px;
      border-radius: 5px;
      background-color: transparent;
      color: white;
      cursor: pointer;
    }
    .menu-item.active,
    .menu-item:hover {
      background-color: white;
      color: #3B0000;
    }
    .main-content {
      margin-left: 280px;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      width: calc(100% - 280px);
    }
    .form-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      max-width: 700px;
      width: 100%;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #3B0000;
      margin-bottom: 30px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
      color: #3B0000;
    }
    input, textarea {
      width: 100%;
      padding: 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
      font-family: 'Poppins', sans-serif;
    }
    button {
      background: #3B0000;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      width: 100%;
    }
    button:hover {
      background: #5a0000;
    }
  </style>
</head>
<body>
<div class="container">
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Seamless</h2>
    <div class="profile-img">
      <img src="../image/User.png" alt="Profile">
    </div>
    <div class="user-id">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></div>
    <div class="user-name"><?= htmlspecialchars($_SESSION['name']) ?><br><?= htmlspecialchars($_SESSION['role']) ?></div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashBuyer.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('sample.php')">Sample</div>
      <div class="menu-item" onclick="navigate('comm.php')">Chat with Marketing</div>
      <div class="menu-item" onclick="navigate('payment.php')">Payments</div>
      <div class="menu-item" onclick="navigate('tracking.php')">Tracking</div>
      <div class="menu-item" onclick="navigate('invoice.php')">Invoice</div>
      <div class="menu-item" onclick="navigate('history.php')">History</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="form-box">
      <h2>Form Pengajuan Produksi Lanjutan</h2>
      <form method="POST">
        <label for="nama_produk">Nama Produk</label>
        <input type="text" name="nama_produk" required>

        <label for="jumlah">Jumlah Produksi</label>
        <input type="number" name="jumlah" required>

        <label for="tanggal_mulai">Tanggal Mulai Produksi</label>
        <input type="date" name="tanggal_mulai" required>

        <label for="catatan">Catatan Tambahan</label>
        <textarea name="catatan" rows="4"></textarea>

        <button type="submit">Kirim Pengajuan</button>
      </form>
    </div>
  </div>
</div>

<script>
  function navigate(url) {
    window.location.href = url;
  }
</script>
</body>
</html>
