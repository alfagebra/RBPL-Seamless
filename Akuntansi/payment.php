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

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Payments & Settlements</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
  <style>
    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #F9F9F9;
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
    }

    .menu-item.active,
    .menu-item:hover {
      background-color: white;
      color: #3B0000;
    }

    .main-content {
      margin-left: 280px;
      padding: 30px 50px;
      width: 100%;
    }

    .section-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .payment-table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 6px rgba(0,0,0,0.1);
    }

    .payment-table th, .payment-table td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .payment-table th {
      background-color: #3B0000;
      color: white;
    }

    .payment-table tr:hover {
      background-color: #f2f2f2;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        flex-direction: row;
        flex-wrap: wrap;
        height: auto;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
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
      <div class="user-id">
        ID: <?= htmlspecialchars($_SESSION['user_id']) ?>
      </div>
      <div class="user-name">
        <?= htmlspecialchars($_SESSION['name']) ?><br>
        <?= htmlspecialchars($_SESSION['role']) ?>
      </div>
      <div class="menu">
        <div class="menu-item" onclick="navigate('dashAkun.php')">Dashboard</div>
        <div class="menu-item active" onclick="navigate('payment.php')">Payments & Settlements</div>
        <div class="menu-item" onclick="navigate('transaksi.php')">Transactions & Cash Flow</div>
        <div class="menu-item" onclick="navigate('comm.php')">Communication & Clarification</div>
        <div class="menu-item" onclick="navigate('invoice.php')">Invoice Management</div>
        <div class="menu-item" onclick="navigate('financial.php')">Financial Reports</div>
        <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="section-title">Payments & Settlements</div>

      <table class="payment-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Buyer</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>04/18/2025</td>
            <td>PT Uniqlo Indonesia</td>
            <td>Rp 25.000.000</td>
            <td>Completed</td>
            <td>DP 50% untuk pesanan #PO12345</td>
          </tr>
          <tr>
            <td>04/20/2025</td>
            <td>H&M Indonesia</td>
            <td>Rp 40.000.000</td>
            <td>Pending</td>
            <td>Menunggu approval dokumen pajak</td>
          </tr>
          <tr>
            <td>04/21/2025</td>
            <td>Female Daily</td>
            <td>Rp 12.500.000</td>
            <td>Completed</td>
            <td>Pelunasan invoice INV-2025-88</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Script -->
  <script>
    function navigate(url) {
      window.location.href = url;
    }
  </script>
</body>
</html>
