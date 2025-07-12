<?php
session_start();
include '../koneksi/koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Accounting Staff') {
    header("Location: ../login/login.php");
    exit;
}
// Cegah session hijacking
session_regenerate_id(true);  
// Cegah caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tanggal = $_POST['tanggal'];
  $deskripsi = $_POST['deskripsi'];
  $tipe = $_POST['tipe'];
  $amount = $_POST['amount'];

  $stmt = $conn->prepare("INSERT INTO transactions (tanggal, deskripsi, tipe, amount) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("sssi", $tanggal, $deskripsi, $tipe, $amount);
  $stmt->execute();
  header("Location: transaksi.php");
  exit;
}

$result = $conn->query("SELECT * FROM transactions ORDER BY tanggal ASC");
$transactions = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Transactions & Cash Flow</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F5F7FA; }
    .container { display: flex; min-height: 100vh; }

    .sidebar {
      width: 280px;
      background-color: #3B0000;
      color: white;
      padding: 30px 20px;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      overflow-y: auto;
    }
    .sidebar h2 {
      font-size: 28px;
      margin-bottom: 20px;
      word-break: break-word;
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
    .profile-img img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
    }
    .user-id, .user-name {
      font-size: 13px;
      margin-bottom: 5px;
      text-align: center;
    }
    .menu { display: flex; flex-direction: column; gap: 15px; }
    .menu-item {
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
      color: white;
    }
    .menu-item.active, .menu-item:hover {
      background-color: white;
      color: #3B0000;
    }

    .main-content {
      flex: 1;
      margin-left: 280px;
      padding: 40px;
      display: flex;
      flex-direction: column;
    }

    .section-title { font-size: 24px; font-weight: 600; margin-bottom: 20px; }
    .add-button {
      background-color: #3B0000;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      margin-bottom: 20px;
      cursor: pointer;
    }

    table {
      width: 100%;
      background: white;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      padding: 12px 16px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th { background-color: #3B0000; color: white; }
    tr:hover { background-color: #f2f2f2; }
    .income { color: green; }
    .expense { color: red; }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      position: relative;
    }
    .modal-content input, .modal-content select {
      width: 100%;
      margin-top: 10px;
      padding: 8px;
      margin-bottom: 15px;
    }
    .modal-content button {
      background-color: #3B0000;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
    }

    .close {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      cursor: pointer;
      color: #999;
    }
    .close:hover {
      color: black;
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
      <div class="user-id">
        ID: <?= htmlspecialchars($_SESSION['user_id']) ?>
      </div>
      <div class="user-name">
        <?= htmlspecialchars($_SESSION['name']) ?><br>
        <?= htmlspecialchars($_SESSION['role']) ?>
      </div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashAkun.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('payment.php')">Payments & Settlements</div>
      <div class="menu-item active" onclick="navigate('transaksi.php')">Transactions & Cash Flow</div>
      <div class="menu-item" onclick="navigate('comm.php')">Communication & Clarification</div>
      <div class="menu-item" onclick="navigate('invoice.php')">Invoice Management</div>
      <div class="menu-item" onclick="navigate('financial.php')">Financial Reports</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <!-- Main content -->
  <div class="main-content">
    <div class="section-title">Transactions & Cash Flow</div>
    <button class="add-button" onclick="document.getElementById('modal').style.display='flex'">+ Add Transaction</button>

    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Description</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Balance</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $saldo = 0;
        foreach ($transactions as $row):
          $class = ($row['tipe'] === 'Income') ? 'income' : 'expense';
          $saldo = ($row['tipe'] === 'Income') ? $saldo + $row['amount'] : $saldo - $row['amount'];
        ?>
        <tr>
          <td><?= htmlspecialchars($row['tanggal']) ?></td>
          <td><?= htmlspecialchars($row['deskripsi']) ?></td>
          <td><?= htmlspecialchars($row['tipe']) ?></td>
          <td class="<?= $class ?>">Rp <?= number_format($row['amount'], 0, ',', '.') ?></td>
          <td>Rp <?= number_format($saldo, 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div id="modal" class="modal" onclick="closeOutside(event)">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <form method="POST">
      <label>Tanggal</label>
      <input type="date" name="tanggal" required>
      <label>Deskripsi</label>
      <input type="text" name="deskripsi" required>
      <label>Tipe</label>
      <select name="tipe" required>
        <option value="Income">Income</option>
        <option value="Expense">Expense</option>
      </select>
      <label>Amount</label>
      <input type="number" name="amount" required>
      <button type="submit">Save</button>
    </form>
  </div>
</div>

<script>
  function navigate(url) {
    window.location.href = url;
  }

  function closeModal() {
    document.getElementById('modal').style.display = 'none';
  }

  function closeOutside(event) {
    if (event.target.id === 'modal') {
      closeModal();
    }
  }
</script>
</body>
</html>
