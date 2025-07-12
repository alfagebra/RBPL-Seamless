<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Marketing Staff') {
    header("Location: ../login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Production Status</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: white;
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
    }
    .sidebar h2 {
      font-family: 'Pacifico', cursive;
      font-size: 28px;
      margin-bottom: 20px;
    }
    .profile-img {
      width: 100px; height: 100px;
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
    .user-id, .user-name {
      font-size: 13px;
      text-align: center;
    }
    .user-name {
      font-size: 15px;
      margin-bottom: 30px;
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
      cursor: pointer;
    }
    .menu-item.active,
    .menu-item:hover {
      background-color: white;
      color: #3B0000;
    }
    .main-content {
      flex: 1;
      padding: 40px;
    }
    .section-title {
      font-size: 22px;
      color: #3B0000;
      font-weight: 600;
      margin-bottom: 30px;
    }
    .timeline {
      background: #EEDADA;
      padding: 30px;
      border-radius: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 40px;
    }
    .step {
      text-align: center;
      width: 120px;
    }
    .step .icon {
      font-size: 24px;
      color: green;
      margin-bottom: 5px;
    }
    .step .desc {
      font-size: 12px;
      color: black;
    }
    .notes {
      background: #FFF7C9;
      padding: 20px;
      width: 400px;
      border-radius: 5px;
      margin-bottom: 20px;
    }
    .download-btn {
      background-color: #7D0000;
      color: white;
      padding: 12px 40px;
      border-radius: 30px;
      font-size: 16px;
      font-style: italic;
      border: none;
      cursor: pointer;
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
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
      <div class="menu-item" onclick="navigate('dashMarketing.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('sample.php')">Sample</div>
      <div class="menu-item" onclick="navigate('production.php')">Production</div>
      <div class="menu-item" onclick="navigate('warehouse.php')">Warehouse Stock</div>
      <div class="menu-item active" onclick="navigate('status.php')">Update Production Status</div>
      <div class="menu-item" onclick="navigate('budget.php')">Upload Budget</div>
      <div class="menu-item" onclick="navigate('report.php')">Report</div>
      <div class="menu-item" onclick="navigate('comm.php')">Communication</div>
    </div>
  </div>

  <!-- Main -->
  <div class="main-content">
    <div class="section-title">Update Production Status</div>

    <div class="timeline">
      <div class="step">
        <div class="icon">✔️</div>
        <div class="desc">Pesanan Diterima<br>25/05/2025<br>09.35</div>
      </div>
      <div class="step">
        <div class="icon">✔️</div>
        <div class="desc">Kain dipotong<br>25/05/2025<br>10.30</div>
      </div>
      <div class="step">
        <div class="icon">✔️</div>
        <div class="desc">Jahit<br>25/05/2025<br>12.45</div>
      </div>
      <div class="step">
        <div class="icon">✔️</div>
        <div class="desc">Pengemasan<br>25/05/2025<br>16.10</div>
      </div>
      <div class="step">
        <div class="icon">✔️</div>
        <div class="desc">QC<br>26/05/2025<br>08.37</div>
      </div>
      <div class="step">
        <div class="icon">✔️</div>
        <div class="desc">Ke Gudang<br>26/05/2025<br>09.25</div>
      </div>
      <div class="step">
        <div class="icon">📦</div>
        <div class="desc">Siap Kirim<br>26/05/2025<br>11.45</div>
      </div>
    </div>

    <div class="notes">
      <strong>Notes</strong><br>
      Total 10 box besar dan 1 box kecil. tiap box besar berisi 150 pcs
    </div>

    <button class="download-btn">Unduh Invoice</button>
  </div>
</div>

<script>
  function navigate(url) {
    window.location.href = url;
  }
</script>
</body>
</html>
