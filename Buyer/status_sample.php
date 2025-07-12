<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
    header("Location: ../login/login.php");
    exit;
}

// Dummy sample tracking
$samples = [
    [
        'nama_produk' => 'Kaos Oversize Putih',
        'status' => 'Dikirim',
        'tanggal_kirim' => '2025-07-08',
        'estimasi_sampai' => '2025-07-12'
    ]
];

function getStatusStep($status) {
    switch ($status) {
        case 'Pending': return 0;
        case 'Dikirim': return 1;
        case 'Diterima': return 2;
        default: return 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tracking Sample</title>
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
      width: 80px; height: 80px;
      border-radius: 50%;
      background: white;
      display: flex; align-items: center; justify-content: center;
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
      width: calc(100% - 280px);
    }

    h2 {
      color: #3B0000;
      text-align: center;
      margin-bottom: 30px;
    }

    .tracking-box {
      background: white;
      padding: 25px;
      border-radius: 10px;
      margin: 0 auto 30px auto;
      max-width: 700px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .product-title {
      font-weight: bold;
      margin-bottom: 10px;
      font-size: 16px;
    }

    .info-dates {
      font-size: 13px;
      color: #555;
      margin-bottom: 20px;
    }

    .progress-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
      margin-top: 10px;
    }

    .line {
      position: absolute;
      top: 15px;
      left: 15px;
      right: 15px;
      height: 4px;
      background-color: #ccc;
      z-index: 0;
    }

    .step {
      position: relative;
      text-align: center;
      z-index: 1;
      width: 33.3%;
    }

    .circle {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #ccc;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 auto 5px auto;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    .active .circle {
      background: #3B0000;
    }

    .step-text {
      font-size: 12px;
      color: #333;
    }
  </style>
</head>
<body>
<div class="container">
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Seamless</h2>
    <div class="profile-img"><img src="../image/User.png" alt="Profile" /></div>
    <div class="user-id">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></div>
    <div class="user-name"><?= htmlspecialchars($_SESSION['name']) ?><br><?= htmlspecialchars($_SESSION['role']) ?></div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashBuyer.php')">Dashboard</div>
      <div class="menu-item active" onclick="navigate('sample.php')">Sample</div>
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
    <h2>Status Pengiriman Sampel</h2>

    <?php foreach ($samples as $s): ?>
      <?php $step = getStatusStep($s['status']); ?>
      <div class="tracking-box">
        <div class="product-title"><?= htmlspecialchars($s['nama_produk']) ?></div>
        <div class="info-dates">
          Tanggal Dikirim: <?= htmlspecialchars($s['tanggal_kirim']) ?><br>
          Estimasi Sampai: <?= htmlspecialchars($s['estimasi_sampai']) ?>
        </div>
        <div class="progress-container">
          <div class="line"></div>
          <div class="step <?= $step >= 0 ? 'active' : '' ?>">
            <div class="circle">⏳</div>
            <div class="step-text">Pending</div>
          </div>
          <div class="step <?= $step >= 1 ? 'active' : '' ?>">
            <div class="circle">🚚</div>
            <div class="step-text">Dikirim</div>
          </div>
          <div class="step <?= $step >= 2 ? 'active' : '' ?>">
            <div class="circle">✅</div>
            <div class="step-text">Diterima</div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
  function navigate(url) {
    window.location.href = url;
  }
</script>
</body>
</html>
