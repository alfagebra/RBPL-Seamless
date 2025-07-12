<?php
session_start();

// Cek apakah user sudah login dan memiliki role yang benar
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Accounting Staff') {
    header("Location: ../login/login.php");
    exit;
}

session_regenerate_id(true); // Cegah session hijacking

// Cegah caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Akuntan</title>
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

    .header {
      background-image: url('../image/dash.png');
      background-size: cover;
      background-position: right;
      background-repeat: no-repeat;
      border-radius: 16px;
      background-color: #3B0000;
      color: white;
      padding: 40px 30px;
      font-size: 24px;
      font-weight: 500;
    }

    .header span {
      font-family: 'Pacifico', cursive;
    }

    .notification-section {
      margin-top: 30px;
    }

    .notification-section h3 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .read-all {
      float: right;
      background-color: #3B0000;
      color: white;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 12px;
      cursor: pointer;
    }

    .notif-list {
      margin-top: 20px;
    }

    .notif-item {
      background-color: #E2D7BE;
      padding: 14px;
      border-radius: 8px;
      margin-bottom: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
    }

    .notif-item .info {
      flex-grow: 1;
      padding: 0 10px;
    }

    .notif-item .info .title {
      font-weight: 600;
      margin-bottom: 3px;
    }

    .notif-item .info .desc {
      font-size: 13px;
    }

    .notif-item .time {
      width: 100px;
      font-size: 12px;
      text-align: center;
    }

    .notif-item .status {
      border-radius: 20px;
      padding: 6px 14px;
      font-size: 12px;
      white-space: nowrap;
    }

    .notif-item .status.unread {
      background-color: #560202;
      color: white;
    }

    .notif-item .status.read {
      background-color: rgba(117, 4, 4, 0.15);
      color: black;
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
        <div class="menu-item active" onclick="navigate('dashAkun.php')">Dashboard</div>
        <div class="menu-item" onclick="navigate('payment.php')">Payments & Settlements</div>
        <div class="menu-item" onclick="navigate('transaksi.php')">Transactions & Cash Flow</div>
        <div class="menu-item" onclick="navigate('comm.php')">Communication & Clarification</div>
        <div class="menu-item" onclick="navigate('invoice.php')">Invoice Management</div>
        <div class="menu-item" onclick="navigate('financial.php')">Financial Reports</div>
        <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="header">
        Hello <?= htmlspecialchars($_SESSION['name']) ?>, welcome to <span>Seamless</span>
      </div>

      <div class="notification-section">
        <h3>Notification <span class="read-all" onclick="markAllRead()">Read All</span></h3>
        <div class="notif-list" id="notifList">
          <!-- Notifikasi Dummy -->
          <div class="notif-item unread" onclick="toggleNotif(this)">
            <div class="time">04/20/2025<br>09:31</div>
            <div class="info">
              <div class="title">Update Sample</div>
              <div class="desc">Sampel sudah dalam perjalanan</div>
            </div>
            <div class="status unread">Unread</div>
          </div>

          <div class="notif-item read" onclick="toggleNotif(this)">
            <div class="time">04/20/2025<br>09:31</div>
            <div class="info">
              <div class="title">Permintaan Pesanan</div>
              <div class="desc">Formulir pengajuan berhasil terkirim</div>
            </div>
            <div class="status read">Already Read</div>
          </div>

          <div class="notif-item read" onclick="toggleNotif(this)">
            <div class="time">04/20/2025<br>09:31</div>
            <div class="info">
              <div class="title">Permintaan Sampel</div>
              <div class="desc">Feedback Sampel diterima dan disetujui</div>
            </div>
            <div class="status read">Already Read</div>
          </div>

          <div class="notif-item unread" onclick="toggleNotif(this)">
            <div class="time">04/20/2025<br>09:31</div>
            <div class="info">
              <div class="title">Komunikasi dengan Marketing</div>
              <div class="desc">Pihak Marketing mengirimkan pesan baru</div>
            </div>
            <div class="status unread">Unread</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    function toggleNotif(elem) {
      const status = elem.querySelector('.status');
      if (status.classList.contains('unread')) {
        status.classList.remove('unread');
        status.classList.add('read');
        status.textContent = 'Already Read';
      } else {
        status.classList.remove('read');
        status.classList.add('unread');
        status.textContent = 'Unread';
      }
    }

    function markAllRead() {
      document.querySelectorAll('.notif-item').forEach(elem => {
        const status = elem.querySelector('.status');
        status.classList.remove('unread');
        status.classList.add('read');
        status.textContent = 'Already Read';
      });
    }

    function navigate(url) {
      window.location.href = url;
    }
  </script>
</body>
</html>
