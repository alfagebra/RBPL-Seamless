<?php
session_start();

// Cek apakah user sudah login dan memiliki role yang benar
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Expedition Staff') {
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
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Ekspedisi</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
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
      font-size: 28px;
      margin-bottom: 20px;
      word-break: break-word;
      text-align: center;
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
      font-weight: normal;
    }

    .main-content {
      flex: 1;
      background-color: #F9F9F9;
      padding: 20px 60px 20px 80px;
      overflow-y: auto;
      margin-left: 280px;
    }

    .header {
      background-image: url('../image/dash.png');
      background-repeat: no-repeat;
      background-position: right center;
      background-size: cover;
      background-color: #3B0000;
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
      font-weight: 400;
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
      color: #F8D5DA;
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
      border-left: 4px solid transparent;
      cursor: pointer;
      gap: 20px;
    }

    .notif-time {
      width: 100px;
      font-size: 12px;
      text-align: center;
      flex-shrink: 0;
    }

    .notif-info {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .notif-title {
      font-weight: bold;
    }

    .notif-status {
      width: 100px;
      text-align: center;
      font-size: 12px;
      padding: 6px 10px;
      border-radius: 20px;
      flex-shrink: 0;
    }

    .notif-status.unread {
      background-color: #560202;
      color: white;
    }

    .notif-status.read {
      background-color: rgba(117, 4, 4, 0.2);
      color: black;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        padding: 20px;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }

      .header {
        flex-direction: column;
        height: auto;
        text-align: center;
      }

      .notif-item {
        flex-direction: column;
        align-items: flex-start;
      }

      .notif-status, .notif-time {
        width: auto;
      }
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
        <div class="menu-item active" onclick="navigate('dashEkspedisi.php')">Dashboard</div>
        <div class="menu-item" onclick="navigate('instruksi.php')">Incoming Delivery Instructions</div>
        <div class="menu-item" onclick="navigate('update.php')">Update Delivery Status</div>
        <div class="menu-item" onclick="navigate('history.php')">Delivery History</div>
        <div class="menu-item" onclick="navigate('chatEks.php')">Communication with Marketing</div>
        <div class="menu-item" onclick="navigate('settingsEks.php')">Settings</div>
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

        <div id="notifList">
          <div class="notif-item unread" onclick="toggleNotif(this)">
            <div class="notif-time">04/20/2025<br>09:31</div>
            <div class="notif-info">
              <div class="notif-title">Produk Siap Dikirim</div>
              <div class="notif-desc">Produk Pesanan #112233 sudah selesai dikemas dan siap dikirimkan</div>
            </div>
            <div class="notif-status unread">Unread</div>
          </div>

          <div class="notif-item unread" onclick="toggleNotif(this)">
            <div class="notif-time">04/20/2025<br>09:31</div>
            <div class="notif-info">
              <div class="notif-title">Sampel Siap Dikirim</div>
              <div class="notif-desc">Produk sampel #114455 sudah jadi, produk siap dikirimkan</div>
            </div>
            <div class="notif-status unread">Unread</div>
          </div>

          <div class="notif-item read" onclick="toggleNotif(this)">
            <div class="notif-time">04/20/2025<br>09:31</div>
            <div class="notif-info">
              <div class="notif-title">Permintaan Pengiriman Masuk</div>
              <div class="notif-desc">Marketing baru saja mengirimkan</div>
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
