<?php
session_start();
include '../koneksi/koneksi.php';

// Cegah akses tanpa login atau bukan Warehouse Staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Expedition Staff') {
    header("Location: ../login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Update Delivery Status</title>
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
      margin-left: 280px;
      overflow-y: auto;
    }

    .page-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .form-container {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      max-width: 600px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-weight: 500;
      margin-bottom: 5px;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    button {
      background-color: #3B0000;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 14px;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #5c0000;
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
        <div class="menu-item" onclick="navigate('dashEkspedisi.php')">Dashboard</div>
        <div class="menu-item" onclick="navigate('instruksi.php')">Incoming Delivery Instructions</div>
        <div class="menu-item active" onclick="navigate('update.php')">Update Delivery Status</div>
        <div class="menu-item" onclick="navigate('history.php')">Delivery History</div>
        <div class="menu-item" onclick="navigate('chatEks.php')">Communication with Marketing</div>
        <div class="menu-item" onclick="navigate('settingsEks.php')">Settings</div>
      </div>
    </div>

    <div class="main-content">
      <div class="page-title">Update Delivery Status</div>
      <div class="form-container">
        <form onsubmit="submitStatus(event)">
          <div class="form-group">
            <label for="orderId">Order ID</label>
            <input type="text" id="orderId" name="orderId" placeholder="Contoh: #112233" required />
          </div>

          <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" required>
              <option value="">Pilih status</option>
              <option value="Diproses">Diproses</option>
              <option value="Dalam Pengiriman">Dalam Pengiriman</option>
              <option value="Terkirim">Terkirim</option>
              <option value="Tertunda">Tertunda</option>
            </select>
          </div>

          <div class="form-group">
            <label for="note">Catatan (opsional)</label>
            <textarea id="note" name="note" rows="4" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
          </div>

          <button type="submit">Kirim Pembaruan</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function navigate(url) {
      window.location.href = url;
    }

    function submitStatus(e) {
      e.preventDefault();
      const orderId = document.getElementById('orderId').value;
      const status = document.getElementById('status').value;
      const note = document.getElementById('note').value;

      alert(`Status pengiriman untuk ${orderId} berhasil diperbarui ke "${status}".`);

      // Di sini kamu bisa menambahkan AJAX/fetch untuk kirim ke backend
      // atau simpan ke localStorage untuk simulasi
    }
  </script>
</body>
</html>
