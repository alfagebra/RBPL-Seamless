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
  <meta charset="UTF-8">
  <title>Finishing & Quality Control</title>
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

    .sidebar h2 {
      font-family: 'Pacifico', cursive;
      font-size: 26px;
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
      padding: 40px 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .header {
      width: 100%;
      max-width: 1000px;
      margin-bottom: 30px;
    }

    .header h2 {
      margin: 0;
      padding-bottom: 10px;
      color: #3B0000;
      font-size: 26px;
      border-bottom: 2px solid #ddd;
    }

    .sample-buttons {
      display: flex;
      flex-direction: column;
      gap: 20px;
      width: 100%;
      max-width: 1000px; /* Lebar penuh */
    }

    .sample-buttons button {
      padding: 18px;
      font-size: 16px;
      font-weight: 500;
      background: linear-gradient(to right, #7b1c1c, #f9b6b6);
      color: white;
      border: none;
      border-radius: 12px;
      text-align: center;
      cursor: pointer;
      transition: background 0.3s;
      width: 100%;
    }

    .sample-buttons button:hover {
      filter: brightness(0.95);
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

      .sample-buttons {
        width: 100%;
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
      <div class="user-id">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></div>
      <div class="user-name">
        <?= htmlspecialchars($_SESSION['name']) ?><br>
        <?= htmlspecialchars($_SESSION['role']) ?>
      </div>
      <div class="menu">
        <div class="menu-item" onclick="navigate('dashGarment.php')">Dashboard</div>
        <div class="menu-item" onclick="navigate('sampleRequest.php')">Sample Request</div>
        <div class="menu-item" onclick="navigate('jadwal.php')">Active Production Schedule</div>
        <div class="menu-item" onclick="navigate('pattern.php')">Pattern & Raw Material Reception</div>
        <div class="menu-item active" onclick="navigate('quality.php')">Finishing & Quality Control</div>
        <div class="menu-item" onclick="navigate('comm.php')">Internal Communication</div>
        <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="header">
        <h2>Finishing & Quality Control</h2>
      </div>

      <div class="sample-buttons">
        <button onclick="navigate('finishing.php')">Finishing</button>
        <button onclick="navigate('qc.php')">Quality Control</button>
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
