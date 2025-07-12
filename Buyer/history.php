<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
    header("Location: ../login/login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM invoices WHERE user_id = $userId ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>History</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
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
      height: 100vh;
      position: fixed;
      overflow-y: auto;
    }

    .sidebar h2 {
      font-family: 'Pacifico', cursive;
      font-size: 28px;
      margin-bottom: 20px;
      text-align: center;
    }

    .profile-img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 10px auto;
    }

    .profile-img img {
      width: 50px;
      height: 50px;
    }

    .user-id, .user-name {
      text-align: center;
      margin-bottom: 5px;
    }

    .user-name {
      margin-bottom: 20px;
    }

    .menu {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .menu-item {
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .menu-item:hover,
    .menu-item.active {
      background-color: white;
      color: #3B0000;
    }

    .main-content {
      flex: 1;
      margin-left: 280px;
      padding: 40px;
    }

    .main-content h2 {
      font-size: 24px;
      margin-bottom: 20px;
      color: #3B0000;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px 16px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #3B0000;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .empty-msg {
      text-align: center;
      color: #666;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
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
      <div class="menu-item" onclick="navigate('invoice.php')">Invoice</div>
      <div class="menu-item active" onclick="navigate('history.php')">History</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h2>Purchase History</h2>
    <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>No. Invoice</th>
          <th>Tanggal</th>
          <th>Total</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['invoice_number']) ?></td>
          <td><?= htmlspecialchars($row['tanggal']) ?></td>
          <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
          <td><?= htmlspecialchars($row['status']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php else: ?>
      <div class="empty-msg">Belum ada riwayat pembelian.</div>
    <?php endif; ?>
  </div>
</div>

<script>
  function navigate(url) {
    window.location.href = url;
  }
</script>
</body>
</html>
