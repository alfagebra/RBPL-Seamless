<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Marketing Staff') {
    header("Location: ../login/login.php");
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['budget_file'])) {
    $uploadDir = '../uploads/budget/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES['budget_file']['name']);
    $targetPath = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

    if (in_array($fileType, ['pdf', 'xls', 'xlsx'])) {
        if (move_uploaded_file($_FILES['budget_file']['tmp_name'], $targetPath)) {
            $success = 'Budget file uploaded successfully.';
            $stmt = $conn->prepare("INSERT INTO budget_uploads (user_id, file_name, upload_date) VALUES (?, ?, NOW())");
            $stmt->bind_param("is", $_SESSION['user_id'], $fileName);
            $stmt->execute();
        } else {
            $error = 'Failed to upload file.';
        }
    } else {
        $error = 'Only PDF, XLS, or XLSX files are allowed.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Upload Budget</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #fdfdfd;
    }
    .container {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 280px;
      background-color: #3B0000;
      color: white;
      padding: 30px 20px 20px 20px;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .sidebar h2 {
      font-family: 'Pacifico', cursive;
      font-size: 28px;
      margin-bottom: 20px;
      text-align: center;
    }
    .profile-img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
    }
    .profile-img img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
    }
    .user-id, .user-name {
      font-size: 13px;
      text-align: center;
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
      flex: 1;
    }

    h2 {
      color: #3B0000;
      margin-bottom: 20px;
    }

    .form-box {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      max-width: 500px;
    }

    input[type="file"] {
      display: block;
      margin: 20px 0;
      font-family: 'Poppins', sans-serif;
    }

    .btn {
      background-color: #3B0000;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 15px;
    }

    .btn:hover {
      background-color: #5c1a1a;
    }

    .message {
      margin-top: 15px;
      font-size: 14px;
    }

    .success {
      color: green;
    }

    .error {
      color: red;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="sidebar">
    <h2>Seamless</h2>
    <div class="profile-img"><img src="../image/User.png" alt="Profile" /></div>
    <div class="user-id">ID: <?= htmlspecialchars($_SESSION['user_id']) ?></div>
    <div class="user-name"><?= htmlspecialchars($_SESSION['name']) ?><br><?= htmlspecialchars($_SESSION['role']) ?></div>
    <div class="menu">
      <div class="menu-item" onclick="navigate('dashMarketing.php')">Dashboard</div>
      <div class="menu-item" onclick="navigate('sample.php')">Sample</div>
      <div class="menu-item" onclick="navigate('production.php')">Production</div>
      <div class="menu-item" onclick="navigate('warehouse.php')">Warehouse Stock</div>
      <div class="menu-item" onclick="navigate('status.php')">Update Production Status</div>
      <div class="menu-item active" onclick="navigate('budget.php')">Upload Budget</div>
      <div class="menu-item" onclick="navigate('report.php')">Report</div>
      <div class="menu-item" onclick="navigate('comm.php')">Communication</div>
      <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
    </div>
  </div>

  <div class="main-content">
    <h2>Upload Budget File</h2>
    <div class="form-box">
      <form action="" method="POST" enctype="multipart/form-data">
        <label for="budget_file">Choose Budget File (PDF / XLS / XLSX):</label>
        <input type="file" name="budget_file" id="budget_file" required>
        <button type="submit" class="btn">Upload</button>
      </form>
      <?php if ($success): ?>
        <div class="message success"><?= $success ?></div>
      <?php elseif ($error): ?>
        <div class="message error"><?= $error ?></div>
      <?php endif; ?>
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
