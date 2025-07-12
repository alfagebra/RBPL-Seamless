<?php
session_start();
include '../koneksi/koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Accounting Staff') {
    header("Location: ../login/login.php");
    exit;
}
// Cegah session hijacking
session_regenerate_id(true);  
// Cegah caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$result = $conn->query("SELECT tipe, amount FROM transactions");
$income = 0;
$expense = 0;

while ($row = $result->fetch_assoc()) {
  if ($row['tipe'] === 'Income') {
    $income += $row['amount'];
  } elseif ($row['tipe'] === 'Expense') {
    $expense += $row['amount'];
  }
}
$balance = $income - $expense;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Financial Reports</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <style>
    * { box-sizing: border-box; }
    body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F5F7FA; }
    .container { display: flex; min-height: 100vh; }

    .sidebar {
      width: 280px;
      background-color: #3B0000;
      color: white;
      padding: 30px 20px;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      overflow-y: auto;
    }

    .sidebar h2 { font-size: 28px; margin-bottom: 20px; text-align: center; }

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
    }

    .menu-item {
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
      color: white;
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
    }

    .section-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .report-card {
      background-color: white;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }

    .report-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 18px;
    }

    .income { color: green; }
    .expense { color: red; }
    .balance { font-weight: bold; }
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
      <div class="user-id">
        ID: <?= htmlspecialchars($_SESSION['user_id']) ?>
      </div>
      <div class="user-name">
        <?= htmlspecialchars($_SESSION['name']) ?><br>
        <?= htmlspecialchars($_SESSION['role']) ?>
      </div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashAkun.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('payment.php')">Payments & Settlements</div>
      <div class="menu-item" onclick="navigate('transaksi.php')">Transactions & Cash Flow</div>
      <div class="menu-item" onclick="navigate('comm.php')">Communication & Clarification</div>
      <div class="menu-item" onclick="navigate('invoice.php')">Invoice Management</div>
      <div class="menu-item active" onclick="navigate('financial.php')">Financial Reports</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <!-- Main content -->
  <div class="main-content">
    <div class="section-title">Financial Reports</div>

    <div class="report-card">
      <div class="report-row">
        <span>Total Income:</span>
        <span class="income">Rp <?= number_format($income, 0, ',', '.') ?></span>
      </div>
      <div class="report-row">
        <span>Total Expense:</span>
        <span class="expense">Rp <?= number_format($expense, 0, ',', '.') ?></span>
      </div>
      <div class="report-row balance">
        <span>Final Balance:</span>
        <span>Rp <?= number_format($balance, 0, ',', '.') ?></span>
      </div>
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
