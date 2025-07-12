<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Garment Staff') {
    header("Location: ../login/login.php");
    exit;
}

require '../koneksi/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sample Requests</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <style>
  * { box-sizing: border-box; }
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
    font-size: 32px;
    margin-bottom: 30px;
    color: white;
    text-align: center;
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
    text-align: center;
  }

  .user-id { font-size: 13px; margin-bottom: 5px; }
  .user-name { font-size: 15px; margin-bottom: 30px; }

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
    transition: background-color 0.3s;
  }

  .menu-item.active,
  .menu-item:hover {
    background-color: white;
    color: #3B0000;
  }

  .main-content {
    margin-left: 280px;
    padding: 40px;
    flex: 1;
  }

  h2 {
    color: #3B0000;
    margin-bottom: 20px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
  }

  th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  th {
    background-color: #3B0000;
    color: white;
  }

  tr:hover {
    background-color: #f1f1f1;
  }

  a.view-link {
    color: #3B0000;
    font-weight: bold;
    text-decoration: underline;
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
        <div class="menu-item" onclick="navigate('dashGarment.php')">Dashboard</div>
        <div class="menu-item active" onclick="navigate('sampleRequest.php')">Sample Request</div>
        <div class="menu-item" onclick="navigate('jadwal.php')">Active Production Schedule</div>
        <div class="menu-item" onclick="navigate('pattern.php')">Pattern & Material</div>
        <div class="menu-item" onclick="navigate('quality.php')">Finishing & QC</div>
        <div class="menu-item" onclick="navigate('comm.php')">Internal Communication</div>
        <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
      </div>
    </div>

    <div class="main-content">
      <h2>Daftar Pengajuan Sample</h2>
      <table>
        <tr>
          <th>No</th>
          <th>Nama Produk</th>
          <th>Bahan</th>
          <th>Ukuran</th>
          <th>Warna</th>
          <th>Desain</th>
          <th>Catatan</th>
          <th>Tanggal</th>
        </tr>

        <?php
$no = 1;
$result = mysqli_query($conn, "SELECT * FROM sample_requests ORDER BY tanggal_pengajuan DESC");

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$no}</td>
            <td>" . htmlspecialchars($row['nama_produk']) . "</td>
            <td>" . htmlspecialchars($row['bahan']) . "</td>
            <td>" . htmlspecialchars($row['ukuran']) . "</td>
            <td>" . htmlspecialchars($row['warna']) . "</td>
            <td>
              <a class='view-link' href='/uploads/desain/" . htmlspecialchars($row['desain']) . "' target='_blank'>Lihat</a>
            </td>
            <td>" . nl2br(htmlspecialchars($row['catatan'])) . "</td>
            <td>" . htmlspecialchars($row['tanggal_pengajuan']) . "</td>
          </tr>";
    $no++;
}
?>

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
