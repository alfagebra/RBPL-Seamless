<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Marketing Staff') {
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
  <title>Dashboard Marketing</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: white;
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
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
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
      width: 100px; height: 100px;
      border-radius: 50%;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
    }
    .profile-img img {
      width: 60px; height: 60px;
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
      padding: 20px 40px;
      flex: 1;
    }
    .header {
      background-color: #3B0000;
      color: white;
      border-radius: 20px;
      padding: 30px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .header h1 {
      margin: 0;
      font-size: 28px;
    }
    .header span {
      font-weight: 400;
    }
    .stats {
      margin-top: 30px;
      display: flex;
      gap: 20px;
      justify-content: center;
    }
    .stat {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      background: #B38D8D;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: #3B0000;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    .stat .percent {
      font-size: 32px;
      font-weight: 600;
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
      gap: 20px;
      font-size: 14px;
    }
    .notif-time {
      width: 110px;
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
    .notif-desc {
      font-size: 13px;
    }
    .notif-status {
      min-width: 90px;
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
  </style>
</head>
<body>
<div class="container">
  <div class="sidebar">
    <h2>Seamless</h2>
    <div class="profile-img"><img src="../image/User.png" alt="Profile"></div>
    <div class="user-id">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></div>
    <div class="user-name"><?= htmlspecialchars($_SESSION['name']) ?><br><?= htmlspecialchars($_SESSION['role']) ?></div>
    <div class="menu">
      <div class="menu-item active" onclick="navigate('dashMarketing.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('sample.php')">Sample</div>
      <div class="menu-item" onclick="navigate('production.php')">Production</div>
      <div class="menu-item" onclick="navigate('warehouse.php')">Warehouse Stock</div>
      <div class="menu-item" onclick="navigate('status.php')">Update Production Status</div>
      <div class="menu-item" onclick="navigate('budget.php')">Upload Budget</div>
      <div class="menu-item" onclick="navigate('report.php')">Report</div>
      <div class="menu-item" onclick="navigate('comm.php')">Communication</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <div class="main-content">
    <div class="header">
      <h1>Hello <?= htmlspecialchars($_SESSION['name']) ?>, welcome to <span>Seamless</span></h1>
    </div>

    <div class="stats">
      <div class="stat">
        <div class="percent" id="sampelPercent">0%</div>
        <div>Sampel Diproses</div>
      </div>
      <div class="stat">
        <div class="percent" id="produksiPercent">0%</div>
        <div>Produksi Berjalan</div>
      </div>
      <div class="stat">
        <div class="percent" id="kirimPercent">0%</div>
        <div>Produk Dikirim</div>
      </div>
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
</div>
<script>
  function navigate(url) {
    window.location.href = url;
  }

  document.addEventListener("DOMContentLoaded", () => {
    fetch("../get_production_stats.php")
      .then(response => response.json())
      .then(data => {
        document.getElementById("sampelPercent").textContent = data.sampel + "%";
        document.getElementById("produksiPercent").textContent = data.produksi + "%";
        document.getElementById("kirimPercent").textContent = data.kirim + "%";
      })
      .catch(err => console.error("Gagal memuat data statistik:", err));
  });

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
</script>
</body>
</html>
