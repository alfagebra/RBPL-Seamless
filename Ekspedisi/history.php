<?php
session_start();
include '../koneksi/koneksi.php';

// Cegah akses tanpa login atau bukan Warehouse Staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Expedition Staff') {
    header("Location: ../login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Delivery History</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
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
      display: flex;
      flex-direction: column;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      height: 100vh;
      overflow-y: auto;
    }

    .sidebar h2 {
      font-size: 28px;
      margin-bottom: 20px;
      word-break: break-word;
      text-align: center;
    }

    .profile-img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
    }

    .profile-img img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
    }

    .user-id {
      font-size: 13px;
      margin-bottom: 5px;
    }

    .user-name {
      font-size: 15px;
      margin-bottom: 30px;
      text-align: center;
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
      font-weight: normal;
    }

    .main-content {
      flex: 1;
      background-color: #F9F9F9;
      padding: 20px 60px 20px 80px;
      margin-left: 280px;
      overflow-y: auto;
    }

    .page-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .history-card {
      background-color: #fff;
      padding: 20px;
      margin-bottom: 15px;
      border-left: 5px solid #3B0000;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .history-card h4 {
      margin: 0 0 8px;
      font-size: 18px;
    }

    .history-card p {
      margin: 4px 0;
      font-size: 14px;
    }

    .status-badge {
      display: inline-block;
      background-color: #3B0000;
      color: white;
      padding: 5px 10px;
      font-size: 12px;
      border-radius: 15px;
      margin-top: 8px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>Seamless</h2>
      <div class="profile-img">
        <img src="../image/User.png" alt="Profile" />
      </div>
      <div class="user-id">
        ID: <?= htmlspecialchars($_SESSION['user_id']) ?>
      </div>
      <div class="user-name">
        <?= htmlspecialchars($_SESSION['name']) ?><br>
        <?= htmlspecialchars($_SESSION['role']) ?>
      </div>
      <div class="menu">
        <div class="menu-item" onclick="navigate('dashEkspedisi.php')">Dashboard</div>
        <div class="menu-item" onclick="navigate('instruksi.php')">Incoming Delivery Instructions</div>
        <div class="menu-item" onclick="navigate('update.php')">Update Delivery Status</div>
        <div class="menu-item active" onclick="navigate('history.php')">Delivery History</div>
        <div class="menu-item" onclick="navigate('chatEks.php')">Communication with Marketing</div>
        <div class="menu-item" onclick="navigate('settingsEks.php')">Settings</div>
      </div>
    </div>

    <div class="main-content">
      <div class="page-title">Delivery History</div>

      <!-- Riwayat pengiriman -->
      <div class="history-card">
        <h4>Order #112233</h4>
        <p><strong>Tanggal:</strong> 20 Juni 2025</p>
        <p><strong>Alamat:</strong> Jl. Industri Raya No. 45, Bandung</p>
        <p><strong>Produk:</strong> Kain Katun Premium</p>
        <span class="status-badge">Terkirim</span>
      </div>

      <div class="history-card">
        <h4>Order #114455</h4>
        <p><strong>Tanggal:</strong> 19 Juni 2025</p>
        <p><strong>Alamat:</strong> Jl. Merdeka Utara No. 12, Surabaya</p>
        <p><strong>Produk:</strong> Kain Denim 14oz</p>
        <span class="status-badge">Tertunda</span>
      </div>

      <div class="history-card">
        <h4>Order #117788</h4>
        <p><strong>Tanggal:</strong> 18 Juni 2025</p>
        <p><strong>Alamat:</strong> Jl. Sudirman No. 88, Jakarta</p>
        <p><strong>Produk:</strong> Kain Linen Polos</p>
        <span class="status-badge">Dalam Pengiriman</span>
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
