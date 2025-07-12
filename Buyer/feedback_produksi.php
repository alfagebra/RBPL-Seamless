<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = intval($_SESSION['user_id']);
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $po_number = mysqli_real_escape_string($conn, $_POST['po_number']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal_penerimaan']);
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    $insert = "INSERT INTO production_feedback (user_id, nama_produk, po_number, tanggal_penerimaan, feedback)
               VALUES ('$userId', '$nama_produk', '$po_number', '$tanggal', '$feedback')";
    if (mysqli_query($conn, $insert)) {
        echo "<script>alert('Feedback berhasil dikirim!'); window.location.href='feedback_produksi.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal mengirim feedback');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Feedback Produksi</title>
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
      width: 80px; height: 80px;
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
    }

    .form-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      max-width: 700px;
      margin: auto;
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
      margin-bottom: 6px;
      font-weight: 500;
      color: #3B0000;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-family: 'Poppins', sans-serif;
    }

    .form-group textarea {
      resize: vertical;
    }

    .terms {
      font-size: 14px;
      color: #3B0000;
      margin-bottom: 20px;
    }

    .terms a {
      text-decoration: underline;
      cursor: pointer;
    }

    .buttons {
      display: flex;
      justify-content: space-between;
    }

    .btn {
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      font-size: 15px;
      cursor: pointer;
      width: 48%;
    }

    .btn-cancel {
      background-color: #ccc;
      color: #333;
    }

    .btn-submit {
      background-color: #3B0000;
      color: white;
    }

    .btn-submit:hover {
      background-color: #5a0000;
    }

    .btn-cancel:hover {
      background-color: #aaa;
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
    <div class="profile-img"><img src="../image/User.png" alt="Profile" /></div>
    <div class="user-id">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></div>
    <div class="user-name"><?= htmlspecialchars($_SESSION['name']) ?><br><?= htmlspecialchars($_SESSION['role']) ?></div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashBuyer.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('sample.php')">Sample</div>
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
      <h2>Feedback Produksi</h2>
      <form method="POST">
        <div class="form-group">
          <label>Nama Produk</label>
          <input type="text" name="nama_produk" placeholder="Pilih Produk" required />
        </div>
        <div class="form-group">
          <label>Nomor PO Produksi</label>
          <input type="text" name="po_number" placeholder="Masukkan Nomor PO" required />
        </div>
        <div class="form-group">
          <label>Tanggal Penerimaan</label>
          <input type="date" name="tanggal_penerimaan" required />
        </div>
        <div class="form-group">
          <label>Feedback dan Review</label>
          <textarea name="feedback" rows="5" placeholder="Tuliskan feedback Anda..." required></textarea>
        </div>

        <div class="terms">
          Telah membaca dan menyetujui <a onclick="showModal()">Terms and Conditions Policy</a> yang Berlaku
        </div>

        <div class="buttons">
          <button class="btn btn-cancel" type="reset">Batal</button>
          <button class="btn btn-submit" type="submit">Kirim Feedback</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="modal" class="modal">
  <div class="modal-content">
    <h3>Syarat dan Ketentuan</h3>
    <ul>
      <li>Feedback hanya berlaku untuk produk yang telah diterima.</li>
      <li>Mohon berikan review secara jujur dan konstruktif.</li>
      <li>Feedback akan digunakan untuk evaluasi kualitas produksi.</li>
      <li>Pastikan data yang dimasukkan sudah sesuai.</li>
    </ul>
    <button onclick="closeModal()">Tutup</button>
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
