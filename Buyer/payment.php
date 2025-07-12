<?php
include '../koneksi/koneksi.php'; // pastikan file ini sesuai path-nya
session_start();
// Cek apakah user sudah login dan memiliki role 'Buyer'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $produk = $_POST['produk'];
    $nominal = $_POST['nominal'];

    // Handle file upload
    $targetDir = "../uploads/";
    $fileName = basename($_FILES["bukti"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // Validasi ekstensi (opsional tapi disarankan)
    $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $targetFilePath)) {
            // Simpan ke database
            $stmt = $conn->prepare("INSERT INTO payments (user_id, produk, nominal, bukti) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $user_id, $produk, $nominal, $fileName);
            $stmt->execute();
            header("Location: payment_success.php"); // buat halaman ini untuk notifikasi sukses
            exit;
        } else {
            echo "Upload file gagal. Silakan coba lagi.";
        }
    } else {
        echo "Format file tidak didukung. Hanya JPG, PNG, atau PDF.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Buyer</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
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
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .form-box {
      background-color: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      max-width: 700px; /* diperbesar */
      width: 100%;
    }

    .form-box h2 {
      margin-top: 0;
      margin-bottom: 20px;
      color: #3B0000;
      text-align: center;
    }

    label {
      display: block;
      margin-top: 20px;
      margin-bottom: 6px;
      font-weight: 500;
      color: #3B0000;
    }

    select,
    input[type="text"],
    input[type="file"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #f9f9f9;
      font-family: 'Poppins', sans-serif;
    }

    input[type="text"]:disabled {
      background-color: #e4e4e4;
      color: #555;
    }

    small {
      font-size: 12px;
      color: #777;
      display: block;
      margin-top: 4px;
    }

    .buttons {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 30px;
    }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      font-weight: 500;
    }

    .btn.cancel {
      background-color: #ccc;
      color: #333;
    }

    .btn.submit {
      background-color: #3B0000;
      color: white;
    }

    .btn.submit:hover {
      background-color: #560000;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        padding: 20px;
        position: relative;
        height: auto;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }

      .form-box {
        padding: 25px;
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
    <div class="user-id">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></div>
    <div class="user-name">
      <?= htmlspecialchars($_SESSION['name']) ?><br>
      <?= htmlspecialchars($_SESSION['role']) ?>
    </div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashBuyer.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('sample.php')">Sample</div>
      <div class="menu-item" onclick="navigate('comm.php')">Chat with Marketing</div>
      <div class="menu-item active" onclick="navigate('payment.php')">Payments</div>
      <div class="menu-item" onclick="navigate('tracking.php')">Tracking</div>
      <div class="menu-item" onclick="navigate('invoice.php')">Invoice</div>
      <div class="menu-item" onclick="navigate('history.php')">History</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <div class="main-content">
    <div class="form-box">
      <h2>Form Pembayaran</h2>
      <form action="proses_payment.php" method="POST" enctype="multipart/form-data">
        <label for="produk">Pilih Produk Tagihan</label>
        <select name="produk" id="produk" required>
          <option value="">-- Pilih Produk --</option>
          <option value="produk1">Produk 1</option>
          <option value="produk2">Produk 2</option>
        </select>

        <label for="uangmuka">Uang Muka / Total Pembayaran</label>
        <input type="text" id="uangmuka" value="Auto Terisi dari Sistem" disabled>

        <label for="nominal">Input Nominal Pembayaran</label>
        <input type="text" id="nominal" name="nominal" placeholder="Contoh: 2500000" required>

        <label for="bukti">Upload Bukti Pembayaran</label>
        <input type="file" id="bukti" name="bukti" accept=".jpg,.jpeg,.png,.pdf" required>
        <small>* Format: JPG, PNG, atau PDF (maksimal 50 MB)</small>

        <div class="buttons">
          <button type="button" class="btn cancel" onclick="navigate('dashBuyer.php')">Batal</button>
          <button type="submit" class="btn submit">Kirim</button>
        </div>
      </form>
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
