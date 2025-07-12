<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Buyer') {
  header("Location: ../login/login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$role = $_SESSION['role'];

// Dummy data
$orderTrack = [
  [
    'order_id' => 1,
    'po_number' => 'PO-20250709-01',
    'product_name' => 'Kaos Oversize Hitam',
    'tracking_status' => 3
  ],
  [
    'order_id' => 2,
    'po_number' => 'PO-20250709-02',
    'product_name' => 'Jaket Hoodie Abu',
    'tracking_status' => 7
  ]
];

$trackingSteps = [
  "Sample Request Submitted",
  "Check Ingredients Stocks",
  "Sample Product On Process",
  "Sample Feedback",
  "Submitting Production Request",
  "Ingredients Indented On Process",
  "Production Is On Progress",
  "Products Packaging On Process",
  "Products On Delivery",
  "Products Delivered"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Tracking</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Poppins', sans-serif; background-color: #F9F9F9; }

    .container { display: flex; min-height: 100vh; }
    .sidebar {
      width: 280px; background-color: #3B0000; color: white;
      padding: 30px 20px; display: flex; flex-direction: column; align-items: center;
      position: fixed; top: 0; left: 0; bottom: 0; overflow-y: auto;
    }

    .sidebar h2 {
      font-family: 'Pacifico', cursive;
      font-size: 28px;
      margin-bottom: 20px;
    }

    .profile-img {
      width: 80px; height: 80px; border-radius: 50%; background: white;
      display: flex; align-items: center; justify-content: center; margin-bottom: 10px;
    }

    .profile-img img {
      width: 50px; height: 50px; border-radius: 50%;
    }

    .user-id { font-size: 13px; margin-bottom: 5px; }
    .user-name { font-size: 15px; margin-bottom: 30px; text-align: center; }

    .menu { display: flex; flex-direction: column; gap: 15px; width: 100%; }
    .menu-item {
      padding: 10px 15px; border-radius: 8px; color: white; cursor: pointer;
      transition: 0.3s;
    }

    .menu-item.active, .menu-item:hover {
      background-color: white; color: #3B0000; font-weight: 500;
    }

    .main-content {
      flex: 1; margin-left: 280px; padding: 40px;
    }

    .page-title {
      font-size: 24px; font-weight: 600; color: #3B0000; margin-bottom: 30px;
    }

    .tracking-box {
      background: white; border-radius: 12px; padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;
    }

    .tracking-box strong { color: #3B0000; }

    .tracking-steps {
      position: relative;
      margin-left: 20px;
      padding-left: 20px;
      border-left: 2px solid #ccc;
    }

    .step {
      position: relative;
      padding: 10px 0 10px 20px;
    }

    .step::before {
      content: '';
      position: absolute;
      left: -12px;
      top: 10px;
      width: 16px;
      height: 16px;
      background-color: #ccc;
      border-radius: 50%;
      border: 2px solid white;
      z-index: 1;
    }

    .step.completed::before {
      background-color: #3B0000;
    }

    .step .label {
      font-size: 14px;
      color: #333;
    }

    .step.completed .label {
      color: #3B0000;
      font-weight: bold;
    }

    .btn-feedback {
      margin-top: 8px;
      background-color: #3B0000;
      color: white;
      padding: 6px 12px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-size: 12px;
    }

    .btn-feedback:hover {
      background-color: #560000;
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
    <div class="user-id">ID: <?= htmlspecialchars($user_id) ?></div>
    <div class="user-name"><?= htmlspecialchars($name) ?><br><?= htmlspecialchars($role) ?></div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashBuyer.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('sampleBuyer.php')">Sample</div>
      <div class="menu-item" onclick="navigate('comm.php')">Chat with Marketing</div>
      <div class="menu-item" onclick="navigate('payment.php')">Payments</div>
      <div class="menu-item active" onclick="navigate('tracking.php')">Tracking</div>
      <div class="menu-item" onclick="navigate('invoice.php')">Invoice</div>
      <div class="menu-item" onclick="navigate('history.php')">History</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <div class="main-content">
    <div class="page-title">Order Tracking</div>

    <?php if (!empty($orderTrack)): ?>
      <?php foreach ($orderTrack as $order): ?>
        <div class="tracking-box">
          <strong>PO Number:</strong> <?= htmlspecialchars($order['po_number']) ?><br>
          <strong>Product:</strong> <?= htmlspecialchars($order['product_name']) ?><br><br>

          <div class="tracking-steps">
            <?php foreach ($trackingSteps as $index => $step): ?>
              <div class="step <?= $index <= $order['tracking_status'] ? 'completed' : '' ?>">
                <div class="label"><?= $step ?></div>
                <?php if ($step === 'Sample Feedback' && $index == $order['tracking_status']): ?>
                  <button class="btn-feedback" onclick="navigate('feedback_sample.php?order_id=<?= $order['order_id'] ?>')">Give Feedback</button>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No tracking data found.</p>
    <?php endif; ?>
  </div>
</div>

<script>
  function navigate(url) {
    window.location.href = url;
  }
</script>

</body>
</html>
