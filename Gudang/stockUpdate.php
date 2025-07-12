<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['name']) || !isset($_SESSION['role'])) {
  header("Location: login.php");
  exit();
}

include '../koneksi/koneksi.php';

// Tambah item baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['add_item'])) {
    $nama_item = $_POST['nama_item'];
    $stok_meter = intval($_POST['stok_meter']);

    $stmt = $conn->prepare("INSERT INTO items (nama_item, stok_meter) VALUES (?, ?)");
    $stmt->bind_param("si", $nama_item, $stok_meter);
    $stmt->execute();
    $stmt->close();
  }

  // Update stok item
  if (isset($_POST['update'])) {
    $id_item = $_POST['id_item'];
    $stok_baru = intval($_POST['stok_meter']);

    $stmt = $conn->prepare("UPDATE items SET stok_meter = ? WHERE id_item = ?");
    $stmt->bind_param("ii", $stok_baru, $id_item);
    $stmt->execute();
    $stmt->close();

    // Perbarui status permintaan item
    $conn->query("
      UPDATE item_requests r
      JOIN items i ON r.nama_item = i.nama_item
      SET r.status_ketersediaan = 
        CASE 
          WHEN i.stok_meter >= r.jumlah_dibutuhkan THEN 'cukup'
          WHEN i.stok_meter < r.jumlah_dibutuhkan THEN 'tidak cukup'
          ELSE 'belum diperiksa'
        END
    ");
  }
}

$result = $conn->query("SELECT * FROM items ORDER BY nama_item ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Stock Availability Update</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
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
      top: 0; left: 0; bottom: 0;
      height: 100vh;
      overflow-y: auto;
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
    }

    .menu-item.active,
    .menu-item:hover {
      background-color: white;
      color: #3B0000;
    }

    .main-content {
      flex: 1;
      margin-left: 280px;
      padding: 40px;
    }

    .page-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      background-color: white;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px 20px;
      font-size: 14px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #3B0000;
      color: white;
    }

    input[type="number"], input[type="text"] {
      padding: 6px;
      width: 100px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      background-color: #3B0000;
      color: white;
      padding: 6px 14px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 13px;
    }

    button:hover {
      background-color: #560000;
    }

    .popup-form {
      display: none;
      position: fixed;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
      z-index: 1000;
    }

    .overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 900;
    }

    .popup-form input {
      display: block;
      margin-bottom: 15px;
      width: 100%;
    }

    .popup-form h3 {
      margin-top: 0;
    }

    .btn-add {
      margin-bottom: 20px;
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
      ID: <?= htmlspecialchars($_SESSION['user_id']) ?><br>
      <?= htmlspecialchars($_SESSION['name']) ?><br>
      <?= htmlspecialchars($_SESSION['role']) ?>
    </div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashGudang.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('itemRequest.php')">Item Request</div>
      <div class="menu-item active" onclick="navigate('stockUpdate.php')">Stock Availability Update</div>
      <div class="menu-item" onclick="navigate('distribution.php')">Distribution to Garment</div>
      <div class="menu-item" onclick="navigate('internalComm.php')">Internal Communication</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <div class="main-content">
    <div class="page-title">Update Stock Gudang</div>

    <button class="btn-add" onclick="openPopup()">+ Tambah Item Baru</button>

    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Bahan</th>
          <th>Stok Sekarang (m)</th>
          <th>Update Jumlah</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while($row = $result->fetch_assoc()): ?>
        <tr>
          <form method="post">
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_item']) ?></td>
            <td><?= $row['stok_meter'] ?> m</td>
            <td>
              <input type="number" name="stok_meter" value="<?= $row['stok_meter'] ?>" min="0" required />
              <input type="hidden" name="id_item" value="<?= $row['id_item'] ?>" />
            </td>
            <td><button type="submit" name="update">Update</button></td>
          </form>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Popup -->
<div class="overlay" onclick="closePopup()"></div>
<div class="popup-form" id="popup">
  <h3>Tambah Item Baru</h3>
  <form method="post">
    <input type="text" name="nama_item" placeholder="Nama Item" required>
    <input type="number" name="stok_meter" placeholder="Stok (meter)" min="0" required>
    <button type="submit" name="add_item">Tambah</button>
    <button type="button" onclick="closePopup()">Batal</button>
  </form>
</div>

<script>
  function navigate(url) {
    window.location.href = url;
  }

  function openPopup() {
    document.querySelector('.popup-form').style.display = 'block';
    document.querySelector('.overlay').style.display = 'block';
  }

  function closePopup() {
    document.querySelector('.popup-form').style.display = 'none';
    document.querySelector('.overlay').style.display = 'none';
  }
</script>
</body>
</html>
