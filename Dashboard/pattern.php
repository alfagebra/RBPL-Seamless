<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Garment Staff') {
    header("Location: ../login/login.php");
    exit;
}

session_regenerate_id(true);
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pattern & Raw Material Reception</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet" />
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
    .sidebar h2 { font-size: 28px; margin-bottom: 20px; text-align: center; }
    .profile-img {
      width: 100px; height: 100px; border-radius: 50%;
      background: white; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;
    }
    .profile-img img { width: 60px; height: 60px; border-radius: 50%; }
    .user-id, .user-name { text-align: center; }
    .user-id { font-size: 13px; margin-bottom: 5px; }
    .user-name { font-size: 15px; margin-bottom: 30px; }
    .menu {
      display: flex; flex-direction: column; gap: 15px; width: 100%;
    }
    .menu-item {
      padding: 10px 15px; border-radius: 5px;
      color: white; cursor: pointer;
      transition: background-color 0.3s;
    }
    .menu-item.active, .menu-item:hover {
      background-color: white; color: #3B0000;
    }

    .main-content {
      flex: 1;
      margin-left: 280px;
      padding: 40px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .header {
      width: 100%;
      max-width: 1000px;
      margin-bottom: 30px;
      border-bottom: 2px solid #ddd;
    }
    .header h2 {
      margin: 0;
      padding-bottom: 10px;
      color: #333;
      font-size: 26px;
    }

    table {
      width: 100%;
      max-width: 1000px;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 14px 18px;
      text-align: center;
      font-size: 14px;
    }

    th {
      background-color: #3B0000;
      color: white;
    }

    tr:nth-child(even) { background-color: #FAFAFA; }
    tr:hover { background-color: #f0f0f0; }

    .status-lengkap {
      color: green;
      font-weight: bold;
    }

    .status-kurang {
      color: red;
      font-weight: bold;
    }

    .status-pending {
      color: goldenrod;
      font-weight: bold;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }

      .header { text-align: center; }
      table { font-size: 12px; }
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
        <div class="menu-item" onclick="navigate('dashGarment.php')">Dashboard</div>
        <div class="menu-item" onclick="navigate('sampleRequest.php')">Sample Request</div>
        <div class="menu-item" onclick="navigate('jadwal.php')">Active Production Schedule</div>
        <div class="menu-item" onclick="navigate('pattern.php')">Pattern & Raw Material Reception</div>
        <div class="menu-item" onclick="navigate('quality.php')">Finishing & Quality Control</div>
        <div class="menu-item" onclick="navigate('comm.php')">Internal Communication</div>
        <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
      </div>
    </div>

    <div class="main-content">
      <div class="header">
        <h2>Pattern & Raw Material Reception</h2>
      </div>

      <table>
        <thead>
          <tr>
            <th>PO Number</th>
            <th>Buyer</th>
            <th>Product</th>
            <th>Pattern</th>
            <th>Material</th>
            <th>Received Date</th>
            <th>Status</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>ORD001</td>
            <td>PT ABC Textiles</td>
            <td>Hoodie Oversize</td>
            <td>hoodie.pdf</td>
            <td>Kain Cotton 20m</td>
            <td>2025-07-11</td>
            <td class="status-lengkap">Lengkap</td>
            <td>-</td>
          </tr>
          <tr>
            <td>ORD002</td>
            <td>PT Global Garment</td>
            <td>Kaos Polos</td>
            <td>kaos.ai</td>
            <td>Kain Combed 30s 15m</td>
            <td>2025-07-10</td>
            <td class="status-kurang">Kurang</td>
            <td>Kurang 2m kain</td>
          </tr>
          <tr>
            <td>ORD003</td>
            <td>PT Fashion Indo</td>
            <td>Jaket Varsity</td>
            <td>varsity_pattern.pdf</td>
            <td>Kain Fleece 25m</td>
            <td>2025-07-09</td>
            <td class="status-pending">Pending</td>
            <td>Menunggu pattern fix</td>
          </tr>
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
