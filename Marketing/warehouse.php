<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Marketing Staff') {
    header("Location: ../login/login.php");
    exit;
}

session_regenerate_id(true);

$stmt = $conn->prepare("SELECT * FROM items ORDER BY updated_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Warehouse Stock</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet" />
  <style>
    * { box-sizing: border-box; }
    body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F9F9F9; }
    .container { display: flex; min-height: 100vh; }
    .sidebar {
      width: 280px; background-color: #3B0000; color: white;
      padding: 30px 20px; position: fixed; top: 0; left: 0; bottom: 0;
      height: 100vh; overflow-y: auto; display: flex; flex-direction: column; align-items: center;
    }
    .sidebar h2 { font-family: 'Pacifico', cursive; font-size: 28px; margin-bottom: 20px; text-align: center; }
    .profile-img { width: 100px; height: 100px; border-radius: 50%; background: white;
      display: flex; align-items: center; justify-content: center; margin-bottom: 10px; }
    .profile-img img { width: 60px; height: 60px; border-radius: 50%; }
    .user-id { font-size: 13px; margin-bottom: 5px; text-align: center; }
    .user-name { font-size: 15px; margin-bottom: 30px; text-align: center; }
    .menu { display: flex; flex-direction: column; gap: 15px; width: 100%; }
    .menu-item {
      padding: 10px 15px; border-radius: 5px;
      background-color: transparent; color: white;
      cursor: pointer; transition: background-color 0.3s;
    }
    .menu-item.active, .menu-item:hover {
      background-color: white; color: #3B0000;
    }

    .main-content {
      flex: 1; margin-left: 280px; padding: 40px;
    }
    .page-title {
      font-size: 24px; font-weight: 600; margin-bottom: 30px;
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
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #3B0000;
      color: white;
    }

    tr:hover {
      background-color: #f3f3f3;
    }

    .empty-msg {
      text-align: center;
      color: #999;
      padding: 20px;
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
    <div class="user-id">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></div>
    <div class="user-name"><?= htmlspecialchars($_SESSION['name']) ?><br><?= htmlspecialchars($_SESSION['role']) ?></div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashMarketing.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('sample.php')">Sample</div>
      <div class="menu-item" onclick="navigate('production.php')">Production</div>
      <div class="menu-item active" onclick="navigate('warehouse.php')">Warehouse Stock</div>
      <div class="menu-item" onclick="navigate('status.php')">Update Production Status</div>
      <div class="menu-item" onclick="navigate('budget.php')">Upload Budget</div>
      <div class="menu-item" onclick="navigate('report.php')">Report</div>
      <div class="menu-item" onclick="navigate('comm.php')">Communication</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <div class="main-content">
    <div class="page-title">Warehouse Stock</div>

    <?php if (count($items) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Item</th>
            <th>Stok (meter)</th>
            <th>Created At</th>
            <th>Updated At</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['id_item']) ?></td>
              <td><?= htmlspecialchars($item['nama_item']) ?></td>
              <td><?= htmlspecialchars($item['stok_meter']) ?></td>
              <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
              <td><?= date('d M Y H:i', strtotime($item['updated_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="empty-msg">Belum ada data stok tersedia.</div>
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
