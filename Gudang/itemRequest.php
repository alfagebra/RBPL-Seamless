<?php
session_start(); // <--- WAJIB untuk akses $_SESSION
include '../koneksi/koneksi.php';

// Ambil data dari tabel item_requests dan join dengan stok dari items
$query = "
SELECT 
  r.tanggal_request,
  r.nama_item,
  r.jumlah_dibutuhkan,
  i.stok_meter
FROM item_requests r
LEFT JOIN items i ON r.nama_item = i.nama_item
ORDER BY r.tanggal_request DESC
";

$result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Item Request - Warehouse</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
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
      height: 100vh;
      overflow-y: auto;
    }

    .sidebar h2 {
      font-family: 'Pacifico', cursive;
      font-size: 28px;
      margin-bottom: 20px;
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
    }

    .page-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .request-table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .request-table th, .request-table td {
      padding: 14px 20px;
      text-align: left;
      font-size: 14px;
    }

    .request-table th {
      background-color: #3B0000;
      color: white;
    }

    .request-table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .status-cukup {
      color: green;
      font-weight: bold;
    }

    .status-kurang {
      color: red;
      font-weight: bold;
    }

    .status-pending {
      color: orange;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>Seamless</h2>
      <div class="profile-img">
        <img src="../image/User.png" alt="Profile">
      </div>
      <div class="user-id">
        ID: <?= htmlspecialchars($_SESSION['user_id']) ?><br>
        <?= htmlspecialchars($_SESSION['name']) ?><br>
        <?= htmlspecialchars($_SESSION['role']) ?>
      </div>
      <div class="menu">
        <div class="menu-item" onclick="navigate('dashGudang.php')">Dashboard</div>
        <div class="menu-item active" onclick="navigate('itemRequest.php')">Item Request</div>
        <div class="menu-item" onclick="navigate('stockUpdate.php')">Stock Availability Update</div>
        <div class="menu-item" onclick="navigate('distribution.php')">Distribution to Garment</div>
        <div class="menu-item" onclick="navigate('internalComm.php')">Internal Communication</div>
        <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
      </div>
    </div>

    <div class="main-content">
      <div class="page-title">Item Request from Garment</div>

      <table class="request-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Item</th>
            <th>Requested Length (m)</th>
            <th>Current Stock (m)</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= date('d/m/Y', strtotime($row['tanggal_request'])) ?></td>
              <td><?= htmlspecialchars($row['nama_item']) ?></td>
              <td><?= intval($row['jumlah_dibutuhkan']) ?> m</td>
              <td><?= $row['stok_meter'] !== null ? intval($row['stok_meter']) . ' m' : '-' ?></td>
              <td>
                <?php
                  if ($row['stok_meter'] === null) {
                    echo '<span class="status-pending">Menunggu Cek</span>';
                  } elseif ($row['stok_meter'] >= $row['jumlah_dibutuhkan']) {
                    echo '<span class="status-cukup">Cukup</span>';
                  } else {
                    echo '<span class="status-kurang">Tidak Cukup</span>';
                  }
                ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" style="text-align:center; padding: 20px;">Tidak ada permintaan item.</td>
          </tr>
        <?php endif; ?>
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
