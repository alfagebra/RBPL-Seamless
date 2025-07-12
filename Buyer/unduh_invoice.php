<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
  header("Location: ../login/login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice Detail - Seamless</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
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
      overflow-y: auto;
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

    .user-id {
      font-size: 13px;
      margin-bottom: 5px;
      text-align: center;
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
    }

    .main-content {
      flex: 1;
      margin-left: 280px;
      padding: 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .search-box {
      margin-top: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .search-box input {
      padding: 10px 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-family: 'Poppins', sans-serif;
      width: 250px;
    }

    .search-box button {
      padding: 10px 20px;
      border-radius: 8px;
      background: #3B0000;
      color: white;
      border: none;
      cursor: pointer;
    }

    .invoice-box {
      width: 100%;
      max-width: 700px;
      background: white;
      border-radius: 15px;
      padding: 30px 25px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
      margin-top: 40px;
    }

    .invoice-box h2 {
      color: #3B0000;
      margin-bottom: 20px;
    }

    .invoice-details {
      text-align: left;
      margin-bottom: 20px;
      font-size: 14px;
      color: #333;
    }

    .invoice-details p {
      margin: 8px 0;
    }

    .download-btn {
      background: #4F1A1A;
      color: white;
      padding: 10px 25px;
      border: none;
      border-radius: 12px;
      font-size: 14px;
      cursor: pointer;
      box-shadow: 0 4px 4px rgba(0,0,0,0.2);
    }

    @media (max-width: 768px) {
      .main-content {
        margin-left: 0;
        padding: 20px;
      }
      .sidebar {
        display: none;
      }
    }
  </style>
</head>
<body>
<div class="container">

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Seamless</h2>
    <div class="profile-img">
      <img src="../image/User.png" alt="Profile" />
    </div>
    <div class="user-id">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></div>
    <div class="user-name">
      <?= htmlspecialchars($_SESSION['name']) ?><br>
      <?= htmlspecialchars($_SESSION['role']) ?>
    </div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashBuyer.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('sample.php')">Sample</div>
      <div class="menu-item" onclick="navigate('comm.php')">Chat with Marketing</div>
      <div class="menu-item" onclick="navigate('payment.php')">Payments</div>
      <div class="menu-item" onclick="navigate('tracking.php')">Tracking</div>
      <div class="menu-item active" onclick="navigate('invoice.php')">Invoice</div>
      <div class="menu-item" onclick="navigate('history.php')">History</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="search-box">
      <input type="text" id="poNumber" placeholder="Masukkan Nomor PO">
      <button onclick="searchPO()">Cari</button>
    </div>

    <div class="invoice-box" id="invoiceBox">
      <h2>Invoice #INV-123456</h2>
      <div class="invoice-details">
        <p><strong>Nama Produk:</strong> Kaos Oblong Premium</p>
        <p><strong>Tanggal Pemesanan:</strong> 12 Juli 2025</p>
        <p><strong>Jumlah:</strong> 100 pcs</p>
        <p><strong>Total:</strong> Rp 5.000.000</p>
      </div>
      <button class="download-btn" onclick="downloadInvoice()">Download Invoice</button>
    </div>
  </div>
</div>

<script>
  function navigate(url) {
    window.location.href = url;
  }

  function searchPO() {
    const po = document.getElementById('poNumber').value.trim();
    if (po) {
      alert('Mencari Invoice untuk PO: ' + po);
    } else {
      alert('Masukkan Nomor PO terlebih dahulu.');
    }
  }

  function downloadInvoice() {
    alert('Mengunduh Invoice...');
  }
</script>
</body>
</html>
