<?php
session_start();
include '../koneksi/koneksi.php';

// Cegah akses tanpa login atau bukan Warehouse Staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Warehouse Staff') {
    header("Location: ../login/login.php");
    exit;
}

// Ambil data permintaan item dengan stok mencukupi
$query = "
    SELECT 
        r.id_request,
        r.tanggal_request,
        r.nama_item,
        r.jumlah_dibutuhkan,
        i.stok_meter
    FROM item_requests r
    JOIN items i ON r.nama_item = i.nama_item
    WHERE i.stok_meter >= r.jumlah_dibutuhkan
    ORDER BY r.tanggal_request DESC
";

$result = $conn->query($query);

// Proses distribusi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['distribusi'])) {
    $id_request = $_POST['id_request'];
    $nama_item = $_POST['nama_item'];
    $jumlah_dibutuhkan = (int) $_POST['jumlah_dibutuhkan'];

    // Update stok dengan prepared statement
    $stmt = $conn->prepare("UPDATE items SET stok_meter = stok_meter - ? WHERE nama_item = ?");
    $stmt->bind_param("is", $jumlah_dibutuhkan, $nama_item);
    $stmt->execute();
    $stmt->close();

    // Hapus request
    $stmt = $conn->prepare("DELETE FROM item_requests WHERE id_request = ?");
    $stmt->bind_param("i", $id_request);
    $stmt->execute();
    $stmt->close();

    header("Location: distribution.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Distribution to Garment</title>
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
      position: fixed;
      top: 0; left: 0; bottom: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
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
      width: 60px; height: 60px; border-radius: 50%;
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
      transition: 0.3s;
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
      border-collapse: collapse;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 14px 20px;
      font-size: 14px;
      text-align: left;
    }
    th {
      background-color: #3B0000;
      color: white;
    }
    form {
      margin: 0;
    }
    button {
      background-color: #3B0000;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.2s;
    }
    button:hover {
      background-color: #5a0000;
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
      <div class="menu-item" onclick="navigate('dashDang.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('itemRequest.php')">Item Request</div>
      <div class="menu-item" onclick="navigate('stockUpdate.php')">Stock Availability Update</div>
      <div class="menu-item active" onclick="navigate('distribution.php')">Distribution to Garment</div>
      <div class="menu-item" onclick="navigate('internalComm.php')">Internal Communication</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>
  <div class="main-content">
    <div class="page-title">Distribusi ke Garment</div>
    <table>
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Item</th>
          <th>Jumlah (m)</th>
          <th>Stok Tersedia (m)</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= date('d/m/Y', strtotime($row['tanggal_request'])) ?></td>
            <td><?= htmlspecialchars($row['nama_item']) ?></td>
            <td><?= (int)$row['jumlah_dibutuhkan'] ?></td>
            <td><?= (int)$row['stok_meter'] ?></td>
            <td>
              <form method="post">
                <input type="hidden" name="id_request" value="<?= $row['id_request'] ?>">
                <input type="hidden" name="nama_item" value="<?= htmlspecialchars($row['nama_item']) ?>">
                <input type="hidden" name="jumlah_dibutuhkan" value="<?= $row['jumlah_dibutuhkan'] ?>">
                <button type="submit" name="distribusi">Distribusikan</button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5" style="text-align:center;">Tidak ada permintaan yang dapat diproses.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<script>
  function navigate(url) {
    window.location.href = url;
  }
</script>
</body>
</html>
