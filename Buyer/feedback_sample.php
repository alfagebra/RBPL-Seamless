<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
    header("Location: ../login/login.php");
    exit;
}

$userId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sample Feedback</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
      padding: 40px;
      width: calc(100% - 280px);
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }

    .form-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      max-width: 700px;
      width: 100%;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #3B0000;
      margin-bottom: 30px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      font-weight: 500;
      margin-bottom: 6px;
      color: #3B0000;
    }
    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    .form-group textarea {
      resize: vertical;
    }
    .terms {
      font-size: 14px;
      margin-top: 10px;
      color: #3B0000;
    }
    .terms a {
      color: #3B0000;
      text-decoration: underline;
      cursor: pointer;
    }
    .buttons {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      margin-top: 25px;
    }
    .btn {
      padding: 10px 18px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-size: 14px;
    }
    .btn-submit {
      background-color: #3B0000;
      color: white;
    }
    .btn-submit:hover {
      background-color: #5a0000;
    }
    .btn-cancel {
      background-color: #ccc;
      color: black;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      max-width: 600px;
      width: 90%;
      text-align: left;
    }
    .modal-content button {
      margin-top: 20px;
      background-color: #3B0000;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
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
    <div class="user-name"><?= htmlspecialchars($_SESSION['name']) ?><br><?= htmlspecialchars($_SESSION['role']) ?></div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashBuyer.php')">Dashboard</div>
      <div class="menu-item active" onclick="navigate('sample.php')">Sample</div>
      <div class="menu-item" onclick="navigate('comm.php')">Chat with Marketing</div>
      <div class="menu-item" onclick="navigate('payment.php')">Payments</div>
      <div class="menu-item" onclick="navigate('tracking.php')">Tracking</div>
      <div class="menu-item" onclick="navigate('invoice.php')">Invoice</div>
      <div class="menu-item" onclick="navigate('history.php')">History</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="form-box">
      <h2>Sample Feedback</h2>
      <form method="POST">
        <div class="form-group">
          <label>Nama Produk</label>
          <input type="text" name="nama_produk" placeholder="Masukkan Nama Produk" required />
        </div>
        <div class="form-group">
          <label>Jumlah Sample</label>
          <input type="text" name="jumlah" placeholder="Contoh: 10 Pcs" required />
        </div>
        <div class="form-group">
          <label>Tanggal Dibutuhkan</label>
          <input type="date" name="tanggal_dibutuhkan" required />
        </div>
        <div class="form-group">
          <label>Tuliskan Feedback</label>
          <textarea name="feedback" placeholder="Tuliskan catatan Anda..." rows="4" required></textarea>
        </div>

        <div class="terms">
          Telah membaca dan menyetujui <a onclick="showModal()">Terms and Conditions Policy</a> yang Berlaku
        </div>

        <div class="buttons">
          <button type="reset" class="btn btn-cancel">Batal</button>
          <button type="submit" class="btn btn-submit">Kirim Permintaan</button>
        </div>
      </form>

      <!-- Modal -->
      <div id="modal" class="modal">
        <div class="modal-content">
          <h3>Syarat dan Ketentuan</h3>
          <ul>
            <li>Feedback ditujukan untuk evaluasi sampel yang sudah diterima.</li>
            <li>Harap sertakan detail yang jelas dan padat.</li>
            <li>Permintaan tambahan akan diproses dalam 2x24 jam.</li>
          </ul>
          <button onclick="closeModal()">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function navigate(url) {
    window.location.href = url;
  }
  function showModal() {
    document.getElementById("modal").style.display = "flex";
  }
  function closeModal() {
    document.getElementById("modal").style.display = "none";
  }
</script>
</body>
</html>
