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
// Ambil data invoice
$result = mysqli_query($conn, "SELECT * FROM invoices ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Invoice Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
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
      top: 0; left: 0; bottom: 0;
      height: 100vh;
      overflow-y: auto;
    }

    .sidebar h2 {
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
      flex: 1;
      margin-left: 280px;
      padding: 40px;
      display: flex;
      flex-direction: column;
    }

    .page-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .invoice-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .invoice-table th,
    .invoice-table td {
      padding: 14px 18px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    .invoice-table th {
      background-color: #3B0000;
      color: white;
    }

    .invoice-table tr:hover {
      background-color: #f4f4f4;
    }

    .status-paid {
      color: green;
      font-weight: bold;
    }

    .status-unpaid {
      color: red;
      font-weight: bold;
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
      <div class="menu-item" onclick="navigate('dashAkun.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('payment.php')">Payments & Settlements</div>
      <div class="menu-item" onclick="navigate('transaksi.php')">Transactions & Cash Flow</div>
      <div class="menu-item" onclick="navigate('comm.php')">Communication & Clarification</div>
      <div class="menu-item active" onclick="navigate('invoice.php')">Invoice Management</div>
      <div class="menu-item" onclick="navigate('financial.php')">Financial Reports</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <div class="main-content">
    <div class="page-title">Invoice Management</div>

    <table class="invoice-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Date</th>
          <th>Invoice Number</th>
          <th>Customer</th>
          <th>Total</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          $statusClass = $row['status'] === 'Paid' ? 'status-paid' : 'status-unpaid';
          echo "<tr>
                  <td>{$no}</td>
                  <td>{$row['tanggal']}</td>
                  <td>{$row['nomor_invoice']}</td>
                  <td>{$row['customer']}</td>
                  <td>Rp " . number_format($row['total'], 0, ',', '.') . "</td>
                  <td class='{$statusClass}'>{$row['status']}</td>
                </tr>";
          $no++;
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  function navigate(url) {
    window.location.href = url;
  }
</script>
</body>
</html>
