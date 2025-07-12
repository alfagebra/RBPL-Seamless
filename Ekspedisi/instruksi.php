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
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Incoming Delivery Instructions</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #F5F7FA;
      color: #333;
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
      transition: background-color 0.3s;
    }

    .menu-item.active,
    .menu-item:hover {
      background-color: white;
      color: #3B0000;
      font-weight: normal;
    }

    .main-content {
      flex: 1;
      background-color: #F5F7FA;
      padding: 40px 50px;
      margin-left: 280px;
      overflow-y: auto;
    }

    .page-title {
      font-size: 26px;
      font-weight: 600;
      margin-bottom: 30px;
      color: #2E2E2E;
    }

    .instruction-card {
      background-color: #fff;
      border: 1px solid #e5e7eb;
      padding: 20px 24px;
      border-radius: 12px;
      margin-bottom: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: 0.3s ease;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .instruction-card:hover {
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      transform: translateY(-2px);
    }

    .instruction-card h4 {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 6px;
      color: #1F2937;
    }

    .instruction-card p {
      font-size: 14px;
      color: #374151;
    }

    .instruction-card p strong {
      color: #111827;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        padding: 20px;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }

      .page-title {
        text-align: center;
      }
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
        <div class="menu-item active" onclick="navigate('instruksi.php')">Incoming Delivery Instructions</div>
        <div class="menu-item" onclick="navigate('update.php')">Update Delivery Status</div>
        <div class="menu-item" onclick="navigate('history.php')">Delivery History</div>
        <div class="menu-item" onclick="navigate('chatEks.php')">Communication with Marketing</div>
        <div class="menu-item" onclick="navigate('settingsEks.php')">Settings</div>
      </div>
    </div>

    <div class="main-content">
      <div class="page-title">Incoming Delivery Instructions</div>

      <div class="instruction-card">
        <h4>Order #112233</h4>
        <p><strong>Customer:</strong> PT. Nusantara Textile</p>
        <p><strong>Address:</strong> Jl. Industri Raya No. 45, Bandung</p>
        <p><strong>Product:</strong> Kain Katun Premium</p>
        <p><strong>Instructions:</strong> Kirim sebelum 30 Juni 2025, gunakan ekspedisi prioritas</p>
      </div>

      <div class="instruction-card">
        <h4>Order #114455</h4>
        <p><strong>Customer:</strong> CV. Anugerah Abadi</p>
        <p><strong>Address:</strong> Jl. Merdeka Utara No. 12, Surabaya</p>
        <p><strong>Product:</strong> Kain Denim 14oz</p>
        <p><strong>Instructions:</strong> Kirim setelah konfirmasi dari bagian marketing</p>
      </div>

      <div class="instruction-card">
        <h4>Order #117788</h4>
        <p><strong>Customer:</strong> PT. Fashion Modern</p>
        <p><strong>Address:</strong> Jl. Sudirman No. 88, Jakarta</p>
        <p><strong>Product:</strong> Kain Linen Polos</p>
        <p><strong>Instructions:</strong> Kirim dengan asuransi, konfirmasi sebelum pengiriman</p>
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
