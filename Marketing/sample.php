<?php 
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Marketing Staff') {
    header("Location: ../login/login.php");
    exit;
}

$query = "SELECT sr.*, u.name AS nama_user 
          FROM sample_requests sr 
          JOIN users u ON sr.user_id = u.user_id 
          ORDER BY sr.tanggal_pengajuan DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Daftar Sampel - Marketing</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
    }
    .container { display: flex; min-height: 100vh; }
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
      width: 50px; height: 50px;
      border-radius: 50%;
    }
    .user-id, .user-name {
      font-size: 13px;
      text-align: center;
      margin-bottom: 5px;
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
      padding: 40px;
      width: calc(100% - 280px);
    }

    h2 {
      color: #3B0000;
      text-align: center;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      font-size: 13px;
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #3B0000;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    a {
      color: #3B0000;
      text-decoration: underline;
    }

    a:hover {
      color: #600000;
    }

    @media (max-width: 768px) {
      .main-content { padding: 20px; }
      table, thead, tbody, th, td, tr { display: block; }
      th { position: absolute; top: -9999px; left: -9999px; }
      tr { border: 1px solid #ccc; margin-bottom: 10px; }
      td {
        border: none;
        position: relative;
        padding-left: 50%;
      }
      td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        font-weight: bold;
      }
    }
  </style>
</head>
<body>
<div class="container">
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Seamless</h2>
    <div class="profile-img"><img src="../image/User.png" alt="Profile"></div>
    <div class="user-id">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></div>
    <div class="user-name"><?= htmlspecialchars($_SESSION['name']) ?><br><?= htmlspecialchars($_SESSION['role']) ?></div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashMarketing.php')">Dashboard</div>
      <div class="menu-item active" onclick="navigate('sample.php')">Sample</div>
      <div class="menu-item" onclick="navigate('production.php')">Production</div>
      <div class="menu-item" onclick="navigate('warehouse.php')">Warehouse Stock</div>
      <div class="menu-item" onclick="navigate('status.php')">Update Production Status</div>
      <div class="menu-item" onclick="navigate('budget.php')">Upload Budget</div>
      <div class="menu-item" onclick="navigate('report.php')">Report</div>
      <div class="menu-item" onclick="navigate('comm.php')">Communication</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h2>Daftar Pengajuan Sampel (All Buyers)</h2>
    <table>
      <thead>
        <tr>
          <th>Buyer</th>
          <th>Nama Produk</th>
          <th>Bahan</th>
          <th>Ukuran</th>
          <th>Warna</th>
          <th>Desain</th>
          <th>Catatan</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td data-label="Buyer"><?= htmlspecialchars($row['nama_user']) ?></td>
              <td data-label="Nama Produk"><?= htmlspecialchars($row['nama_produk']) ?></td>
              <td data-label="Bahan"><?= htmlspecialchars($row['bahan']) ?></td>
              <td data-label="Ukuran"><?= htmlspecialchars($row['ukuran']) ?></td>
              <td data-label="Warna"><?= htmlspecialchars($row['warna']) ?></td>
              <td data-label="Desain">
                <?php if ($row['desain']): ?>
                  <a href="../uploads/desain/<?= htmlspecialchars($row['desain']) ?>" target="_blank">Lihat</a>
                <?php else: ?>
                  -
                <?php endif; ?>
              </td>
              <td data-label="Catatan"><?= htmlspecialchars($row['catatan']) ?></td>
              <td data-label="Tanggal"><?= date('d M Y', strtotime($row['tanggal_pengajuan'])) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="8" style="text-align:center;">Belum ada pengajuan.</td></tr>
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
