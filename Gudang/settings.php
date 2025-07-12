<?php
session_start();
include '../koneksi/koneksi.php';

// Cegah halaman di-cache setelah logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login/login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data user dari database
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Settings</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
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
      margin-bottom: 5px;
      text-align: center;
    }

    .user-name {
      font-size: 15px;
      font-weight: 600;
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
      font-weight: normal;
    }

    .main-content {
      flex: 1;
      background-color: #F9F9F9;
      padding: 20px 60px 20px 80px;
      margin-left: 280px;
      overflow-y: auto;
    }

    .page-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .settings-box {
      background-color: white;
      padding: 40px;
      border-radius: 12px;
      max-width: 700px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .settings-box .icon {
      width: 100px;
      height: 100px;
      background-color: #f0f0f0;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 40px;
      margin: 0 auto 20px;
      color: #3B0000;
    }

    .settings-box h3 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
    }

    .settings-info {
      font-size: 16px;
      line-height: 1.8;
      padding: 0 30px;
    }

    .settings-info strong {
      display: inline-block;
      width: 100px;
    }

    .logout-btn {
      margin-top: 30px;
      background-color: #3B0000;
      color: white;
      border: none;
      padding: 12px 30px;
      font-size: 16px;
      border-radius: 30px;
      cursor: pointer;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    .logout-btn:hover {
      background-color: #5e0000;
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
        <div class="menu-item" onclick="navigate('itemRequest.php')">Item Request</div>
        <div class="menu-item" onclick="navigate('stockUpdate.php')">Stock Availability Update</div>
        <div class="menu-item" onclick="navigate('distribution.php')">Distribution to Garment</div>
        <div class="menu-item" onclick="navigate('internalComm.php')">Internal Communication</div>
        <div class="menu-item active" onclick="navigate('settings.php')">Settings</div>
      </div>
    </div>

    <div class="main-content">
      <div class="page-title">Settings</div>
      <div class="settings-box">
        <div class="icon">👤</div>
        <h3><?= htmlspecialchars($user['user_id']) ?></h3>
        <div class="settings-info">
          <p><strong>ID</strong>: <?= htmlspecialchars($user['user_id']) ?></p>
          <p><strong>Name</strong>: <?= htmlspecialchars($user['name']) ?></p>
          <p><strong>Company</strong>: <?= htmlspecialchars($user['company'] ?? 'PT SRITEX Tbk.') ?></p>
          <p><strong>E-Mail</strong>: <?= htmlspecialchars($user['email']) ?></p>
          <p><strong>Role</strong>: <?= htmlspecialchars($user['role']) ?></p>
        </div>
        <button class="logout-btn" onclick="logout()">Logout</button>
      </div>
    </div>
  </div>

  <script>
    function navigate(url) {
      window.location.href = url;
    }

    function logout() {
      if (confirm('Are you sure you want to logout?')) {
        window.location.href = '../login/logout.php';
      }
    }
  </script>
</body>
</html>
