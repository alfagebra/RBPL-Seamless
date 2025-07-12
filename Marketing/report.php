<?php
session_start();

// Simulasi data dummy
$dummyData = [
  [
    'project_name' => 'Jacket Alpha',
    'buyer_name' => 'Buyer A',
    'sample_date' => '2024-05-01',
    'garment_status' => 'Done',
    'finishing_status' => 'In Progress',
    'qc_status' => 'Pending',
    'warehouse_status' => 'Pending',
    'shipping_status' => 'Pending',
  ],
  [
    'project_name' => 'Polo Beta',
    'buyer_name' => 'Buyer B',
    'sample_date' => '2024-05-03',
    'garment_status' => 'Done',
    'finishing_status' => 'Done',
    'qc_status' => 'Done',
    'warehouse_status' => 'Done',
    'shipping_status' => 'Sent',
  ],
  [
    'project_name' => 'T-Shirt Gamma',
    'buyer_name' => 'Buyer C',
    'sample_date' => '2024-06-10',
    'garment_status' => 'In Progress',
    'finishing_status' => 'Pending',
    'qc_status' => 'Pending',
    'warehouse_status' => 'Pending',
    'shipping_status' => 'Pending',
  ]
];

function statusBadge($status) {
  switch ($status) {
    case 'Pending': return '<span class="status status-pending">Pending</span>';
    case 'In Progress': return '<span class="status status-progress">In Progress</span>';
    case 'Done': return '<span class="status status-done">Done</span>';
    case 'Sent': return '<span class="status status-sent">Sent</span>';
    default: return '<span class="status status-pending">-</span>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Production Report - Marketing</title>
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
      padding: 30px;
      width: calc(100% - 280px);
    }

    h2 {
      color: #3B0000;
      text-align: center;
      margin-bottom: 25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      font-size: 13px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 10px 12px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #3B0000;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .status {
      padding: 4px 8px;
      border-radius: 4px;
      display: inline-block;
      font-size: 12px;
    }
    .status-pending { background-color: #f8d7da; color: #721c24; }
    .status-progress { background-color: #fff3cd; color: #856404; }
    .status-done { background-color: #d4edda; color: #155724; }
    .status-sent { background-color: #cce5ff; color: #004085; }
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
      <div class="menu-item" onclick="navigate('sample.php')">Sample</div>
      <div class="menu-item" onclick="navigate('production.php')">Production</div>
      <div class="menu-item" onclick="navigate('warehouse.php')">Warehouse Stock</div>
      <div class="menu-item" onclick="navigate('status.php')">Update Production Status</div>
      <div class="menu-item" onclick="navigate('budget.php')">Upload Budget</div>
      <div class="menu-item active" onclick="navigate('report.php')">Report</div>
      <div class="menu-item" onclick="navigate('comm.php')">Communication</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h2>Production Report</h2>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Project Name</th>
          <th>Buyer</th>
          <th>Sample In</th>
          <th>Garment</th>
          <th>Finishing</th>
          <th>QC</th>
          <th>Warehouse</th>
          <th>Shipping</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; foreach ($dummyData as $row): 
          $finalStatus = ($row['shipping_status'] === 'Sent') ? 'Completed' : 'On Going';
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['project_name']) ?></td>
          <td><?= htmlspecialchars($row['buyer_name']) ?></td>
          <td><?= htmlspecialchars($row['sample_date']) ?></td>
          <td><?= statusBadge($row['garment_status']) ?></td>
          <td><?= statusBadge($row['finishing_status']) ?></td>
          <td><?= statusBadge($row['qc_status']) ?></td>
          <td><?= statusBadge($row['warehouse_status']) ?></td>
          <td><?= statusBadge($row['shipping_status']) ?></td>
          <td><strong><?= $finalStatus ?></strong></td>
        </tr>
        <?php endforeach; ?>
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
