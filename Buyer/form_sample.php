<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
    header("Location: ../login/login.php");
    exit;
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi session user_id
    if (empty($_SESSION['user_id'])) {
        echo "<script>alert('Session user ID tidak valid. Silakan login ulang.');</script>";
        exit;
    }

    $user_id = $_SESSION['user_id']; // VARCHAR
    $nama_produk = $_POST['nama_produk'];
    $bahan = $_POST['bahan'];
    $ukuran = $_POST['ukuran'];
    $warna = $_POST['warna'];
    $catatan = $_POST['catatan'];

    $upload_dir = "../uploads/desain/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $desain_name = $_FILES['desain']['name'];
    $desain_tmp = $_FILES['desain']['tmp_name'];
    $desain_ext = pathinfo($desain_name, PATHINFO_EXTENSION);
    $desain_new = uniqid("desain_") . "." . $desain_ext;
    $target_path = $upload_dir . $desain_new;

    if (move_uploaded_file($desain_tmp, $target_path)) {
        $stmt = $conn->prepare("INSERT INTO sample_requests (user_id, nama_produk, bahan, ukuran, warna, desain, catatan) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $user_id, $nama_produk, $bahan, $ukuran, $warna, $desain_new, $catatan);
        if ($stmt->execute()) {
            echo "<script>alert('Pengajuan sampel berhasil!'); window.location.href='sample.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan data ke database.');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload file desain.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Form Sample</title>
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
      display: flex;
      justify-content: center;
      align-items: flex-start;
      width: calc(100% - 280px);
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
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
      color: #3B0000;
    }
    input, textarea, select {
      width: 100%;
      padding: 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
    }

    .terms-container {
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      font-size: 14px;
      color: #3B0000;
      padding-left: 2px;
    }

    .terms-container input[type="checkbox"] {
      margin-right: 10px;
      transform: scale(1.2);
      accent-color: #3B0000;
    }

    .terms-link {
      text-decoration: underline;
      cursor: pointer;
      color: #3B0000;
    }

    .terms-link:hover {
      color: #600000;
    }

    button {
      background: #3B0000;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      width: 100%;
    }
    button:hover {
      background: #5a0000;
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
      <h2>Form Pengajuan Sampel</h2>
      <form method="POST" enctype="multipart/form-data">
        <label for="nama_produk">Nama Produk</label>
        <input type="text" name="nama_produk" required>

        <label for="bahan">Jenis Bahan</label>
        <input type="text" name="bahan" required>

        <label for="ukuran">Ukuran</label>
        <select name="ukuran" required>
          <option value="">-- Pilih Ukuran --</option>
          <option value="XS">XS</option>
          <option value="S">S</option>
          <option value="M">M</option>
          <option value="L">L</option>
          <option value="XL">XL</option>
          <option value="Semua Ukuran">Semua Ukuran</option>
        </select>

        <label for="warna">Warna</label>
        <input type="text" name="warna" required>

        <label for="desain">Upload Desain Pakaian</label>
        <input type="file" name="desain" accept=".jpg,.jpeg,.png,.pdf" required>

        <label for="catatan">Catatan Tambahan</label>
        <textarea name="catatan" rows="4"></textarea>

        <!-- Terms and Conditions -->
        <div class="terms-container">
          <input type="checkbox" id="agree" required />
          <label for="agree">
            Saya telah membaca dan menyetujui <a class="terms-link" onclick="showModal()">Syarat dan Ketentuan</a> yang berlaku.
          </label>
        </div>

        <button type="submit">Kirim Pengajuan</button>
      </form>

      <!-- Modal -->
      <div id="modal" class="modal">
        <div class="modal-content">
          <h3>Syarat dan Ketentuan</h3>
          <ul>
            <li>Sampel hanya dapat diajukan oleh pengguna terdaftar sebagai Buyer.</li>
            <li>Desain yang dikirim adalah milik pengguna.</li>
            <li>Pihak Seamless berhak menolak desain yang tidak sesuai.</li>
            <li>Seluruh pengajuan harus menyertakan data lengkap.</li>
            <li>Estimasi proses pengiriman adalah 7 hari kerja.</li>
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
