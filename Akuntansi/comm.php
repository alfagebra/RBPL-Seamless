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

$receiver = $_GET['with'] ?? 'marketing';
$sender = 'accounting'; // Sender adalah akuntansi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $message = trim($_POST['message']);
  if (!empty($message)) {
    $stmt = $conn->prepare("INSERT INTO messages (sender, receiver, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $sender, $receiver, $message);
    $stmt->execute();
  }
}

$stmt = $conn->prepare("SELECT * FROM messages WHERE 
  (sender = ? AND receiver = ?) OR 
  (sender = ? AND receiver = ?)
  ORDER BY timestamp ASC
");
$stmt->bind_param("ssss", $sender, $receiver, $receiver, $sender);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Chat Akuntansi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
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
      font-size: 28px;
      margin-bottom: 20px;
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
      display: flex;
      flex-direction: column;
    }

    .page-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .chat-box {
      flex: 1;
      background: white;
      border-radius: 10px;
      display: flex;
      flex-direction: column;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .chat-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      border-bottom: 1px solid #ccc;
    }

    .chat-header h4 {
      margin: 0;
      font-weight: 500;
    }

    .chat-header .icons {
      display: flex;
      gap: 10px;
    }

    .chat-header .icons button {
      background: none;
      border: none;
      font-size: 18px;
      cursor: pointer;
    }

    .chat-body {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .chat-message {
      max-width: 60%;
      padding: 10px 15px;
      border-radius: 10px;
      background-color: #eee;
      position: relative;
    }

    .chat-message.self {
      align-self: flex-end;
      background-color: #3B0000;
      color: white;
    }

    .chat-message small {
      display: block;
      font-size: 10px;
      margin-top: 5px;
      color: #999;
    }

    .chat-footer {
      display: flex;
      padding: 15px;
      border-top: 1px solid #ccc;
    }

    .chat-footer input {
      flex: 1;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-right: 10px;
    }

    .chat-footer button {
      padding: 10px 16px;
      background-color: #3B0000;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .chat-footer button:hover {
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
        <div class="menu-item" onclick="navigate('transaksi.php')">Transactions & Cash Flow</div>
        <div class="menu-item active" onclick="navigate('comm.php')">Communication & Clarification</div>
        <div class="menu-item" onclick="navigate('invoice.php')">Invoice Management</div>
        <div class="menu-item" onclick="navigate('financial.php')">Financial Reports</div>
        <div class="menu-item" onclick="navigate('settings.php')">Settings</div>
      </div>
  </div>

  <div class="main-content">
    <div class="page-title">Chat with Marketing</div>

    <div class="chat-box">
      <div class="chat-header">
        <h4>Marketing</h4>
        <div class="icons">
          <button title="Call">📞</button>
          <button title="Video Call">📹</button>
        </div>
      </div>

      <div class="chat-body" id="chat-body">
        <?php foreach ($messages as $msg): ?>
          <div class="chat-message <?= $msg['sender'] === $sender ? 'self' : '' ?>">
            <?= htmlspecialchars($msg['message']) ?>
            <small><?= date('d M Y H:i', strtotime($msg['timestamp'])) ?></small>
          </div>
        <?php endforeach; ?>
      </div>

      <form class="chat-footer" method="POST">
        <input type="text" name="message" placeholder="Type your message..." autocomplete="off" required />
        <button type="submit">Send</button>
      </form>
    </div>
  </div>
</div>

<script>
  function navigate(url) {
    window.location.href = url;
  }

  // Auto scroll to bottom
  const chatBody = document.getElementById('chat-body');
  chatBody.scrollTop = chatBody.scrollHeight;
</script>
</body>
</html>
