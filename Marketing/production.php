<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Marketing Staff') {
    header("Location: ../login/login.php");
    exit;
}

// Dummy Data Produksi
$production_data = [
    ['buyer' => 'Zara', 'order' => 'ORD-001', 'produced' => 800, 'target' => 1000],
    ['buyer' => 'H&M', 'order' => 'ORD-002', 'produced' => 450, 'target' => 500],
    ['buyer' => 'Uniqlo', 'order' => 'ORD-003', 'produced' => 1200, 'target' => 1500]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Production - Seamless</title>
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

    /* Sidebar */
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
      gap: 10px;
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

    /* Main Content */
    .main-content {
      margin-left: 280px;
      padding: 40px;
      width: calc(100% - 280px);
    }

    .card {
      background-color: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card h3 {
      margin-top: 0;
      color: #3B0000;
    }

    .progress-container {
      background-color: #ddd;
      border-radius: 20px;
      overflow: hidden;
      height: 20px;
    }

    .progress-bar {
      background-color: #3B0000;
      height: 100%;
      text-align: center;
      color: white;
      line-height: 20px;
      white-space: nowrap;
    }
  </style>
</head>
<body>
<div class="container">
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Seamless</h2>
    <div class="profile-img"><img src="../image/User.png" alt="Profile"></div>
    <div class="user-id">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></div>
    <div class="user-name"><?= htmlspecialchars($_SESSION['name']) ?><br><?= htmlspecialchars($_SESSION['role']) ?></div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashMarketing.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('sample.php')">Sample</div>
      <div class="menu-item active" onclick="navigate('production.php')">Production</div>
      <div class="menu-item" onclick="navigate('warehouse.php')">Warehouse Stock</div>
      <div class="menu-item" onclick="navigate('status.php')">Update Production Status</div>
      <div class="menu-item" onclick="navigate('budget.php')">Upload Budget</div>
      <div class="menu-item" onclick="navigate('report.php')">Report</div>
      <div class="menu-item" onclick="navigate('comm.php')">Communication</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h1 style="color:#3B0000;">Production Efficiency Tracker</h1>

    <?php foreach ($production_data as $data): 
      $percentage = round(($data['produced'] / $data['target']) * 100);
      if ($percentage > 100) $percentage = 100;
    ?>
      <div class="card">
        <h3><?= $data['buyer']; ?> - <?= $data['order']; ?></h3>
        <p>Produced: <?= $data['produced']; ?> pcs / Target: <?= $data['target']; ?> pcs</p>
        <div class="progress-container">
          <div class="progress-bar" style="width: <?= $percentage; ?>%;"><?= $percentage; ?>%</div>
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
