<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Warehouse Staff') {
    header("Location: ../login/login.php");
    exit;
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Warehouse</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

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
      background-color: #F9F9F9;
      padding: 20px 60px 20px 80px;
      margin-left: 280px;
      overflow-y: auto;
    }

    .header {
      background-color: #3B0000;
      background-image: url('../image/dash.png');
      background-repeat: no-repeat;
      background-position: right center;
      background-size: cover;
      color: white;
      border-radius: 20px;
      padding: 30px 40px;
      height: 100px;
      display: flex;
      align-items: center;
    }

    .header h1 {
      margin: 0;
      font-size: 28px;
    }

    .header h1 span {
      font-family: 'Pacifico', cursive;
    }

    .notification {
      margin-top: 40px;
    }

    .notification-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .notification-header h3 {
      margin: 0;
      font-size: 20px;
    }

    .read-all {
      background-color: #3B0000;
      color: white;
      padding: 5px 12px;
      border-radius: 5px;
      font-size: 13px;
      cursor: pointer;
    }

    .notif-item {
      background-color: #E2D7BE;
      margin: 8px 0;
      padding: 15px;
      border-radius: 5px;
      display: flex;
      align-items: center;
      gap: 20px;
      cursor: pointer;
    }

    .notif-time {
      width: 100px;
      font-size: 12px;
      text-align: center;
    }

    .notif-info {
      flex: 1;
    }

    .notif-title {
      font-weight: bold;
    }

    .notif-desc {
      font-size: 14px;
    }

    .notif-status {
      width: 100px;
      text-align: center;
      font-size: 12px;
      padding: 6px 10px;
      border-radius: 20px;
    }

    .notif-status.unread {
      background-color: #560202;
      color: white;
    }

    .notif-status.read {
      background-color: #F0E0E0;
      color: black;
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
        <div class="menu-item active" onclick="navigate('dashGudang.php')">Dashboard</div>
        <div class="menu-item" onclick="navigate('itemRequest.php')">Item Request</div>
        <div class="menu-item" onclick="navigate('stockUpdate.php')">Stock Availability Update</div>
        <div class="menu-item" onclick="navigate('distribution.php')">Distribution to Garment</div>
        <div class="menu-item" onclick="navigate('internalComm.php')">Internal Communication</div>
        <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
      </div>
    </div>

    <div class="main-content">
      <div class="header">
        <h1>Hello <?= htmlspecialchars($_SESSION['name']) ?>, welcome to <span>Seamless</span></h1>
      </div>

      <div class="notification">
        <div class="notification-header">
          <h3>Notification</h3>
          <div class="read-all" onclick="markAllRead()">Read All</div>
        </div>

        <div class="notif-item unread" onclick="toggleNotif(this)">
          <div class="notif-time">04/20/2025<br>09:31</div>
          <div class="notif-info">
            <div class="notif-title">Update Produksi</div>
            <div class="notif-desc">Garment memperbarui proses produksi pesanan 124321 menjadi Siap dikemas.</div>
          </div>
          <div class="notif-status unread">Unread</div>
        </div>

        <div class="notif-item read" onclick="toggleNotif(this)">
          <div class="notif-time">04/20/2025<br>09:31</div>
          <div class="notif-info">
            <div class="notif-title">Permintaan Pesanan</div>
            <div class="notif-desc">TodayforDaily mengajukan pesanan baru Produk Blouse dengan jumlah dan detail berikut.</div>
          </div>
          <div class="notif-status read">Already Read</div>
        </div>

        <div class="notif-item read" onclick="toggleNotif(this)">
          <div class="notif-time">04/20/2025<br>09:31</div>
          <div class="notif-info">
            <div class="notif-title">Permintaan Sampel</div>
            <div class="notif-desc">PT Hindo meminta Sampel Produk Dres dengan detail berikut</div>
          </div>
          <div class="notif-status read">Already Read</div>
        </div>

        <div class="notif-item unread" onclick="toggleNotif(this)">
          <div class="notif-time">04/20/2025<br>09:31</div>
          <div class="notif-info">
            <div class="notif-title">Komunikasi dengan Buyer</div>
            <div class="notif-desc">Buyer FemaleDaily mengirimkan pesan terkait detail Pesanan.</div>
          </div>
          <div class="notif-status unread">Unread</div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function toggleNotif(elem) {
      elem.classList.toggle('read');
      elem.classList.toggle('unread');
      const status = elem.querySelector('.notif-status');
      if (elem.classList.contains('read')) {
        status.textContent = "Already Read";
        status.classList.remove('unread');
        status.classList.add('read');
      } else {
        status.textContent = "Unread";
        status.classList.remove('read');
        status.classList.add('unread');
      }
    }

    function markAllRead() {
      document.querySelectorAll('.notif-item').forEach(elem => {
        elem.classList.add('read');
        elem.classList.remove('unread');
        const status = elem.querySelector('.notif-status');
        status.textContent = "Already Read";
        status.classList.remove('unread');
        status.classList.add('read');
      });
    }

    function navigate(url) {
      window.location.href = url;
    }
  </script>
</body>
</html>
