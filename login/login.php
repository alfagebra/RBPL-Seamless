<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      display: flex;
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      width: 90%;
      max-width: 900px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .left-panel {
      flex: 1;
      background-color: #3B0000;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0;
      overflow: hidden;
    }

    .left-panel img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }

    .right-panel {
      flex: 1;
      padding: 40px 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .login-title {
      font-size: 28px;
      font-weight: 600;
      color: #3B0000;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    label {
      font-size: 14px;
      color: #333;
    }

    input[type="text"],
    input[type="password"] {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    .custom-dropdown {
      position: relative;
      user-select: none;
    }

    .selected {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      background-color: #fff;
      cursor: pointer;
    }

    .options {
      position: absolute;
      width: 100%;
      border: 1px solid #ccc;
      background-color: white;
      z-index: 10;
      border-radius: 6px;
      display: none;
      max-height: 150px;
      overflow-y: auto;
    }

    .options.active {
      display: block;
    }

    .option {
      padding: 10px;
      cursor: pointer;
    }

    .option:hover {
      background-color: #f0f0f0;
    }

    .show-password {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    button[type="submit"] {
      padding: 12px;
      background-color: #3B0000;
      color: white;
      font-weight: 500;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s;
    }

    button[type="submit"]:hover {
      background-color: #5e0f0f;
    }

    .input-error {
    border: 2px solid red !important;
    }

    @media screen and (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .left-panel {
        display: none;
      }

      .right-panel {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left-panel">
      <img src="../image/img_login.png" alt="Login illustration">
    </div>
    <div class="right-panel">
      <h1 class="login-title">Login!</h1>
      <form action="login_proses.php" method="POST">
        <label for="role">Login as</label>
        <div class="custom-dropdown">
          <div class="selected">Select Position</div>
          <div class="options">
            <div class="option">Buyer</div>
            <div class="option">Marketing Staff</div>
            <div class="option">Garment Staff</div>
            <div class="option">Warehouse Staff</div>
            <div class="option">Accounting Staff</div>
            <div class="option">Expedition Staff</div>
          </div>
        </div>
        <input type="hidden" name="role" id="role" required>

        <label for="user_id">User ID</label>
        <input type="text" name="user_id" id="user_id" placeholder="Enter your ID" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your Password" required>

        <div class="show-password">
          <input type="checkbox" id="showPassword">
          <label for="showPassword">Show Password</label>
        </div>

        <button type="submit">Login</button>
      </form>
    </div>
  </div>

 <script>
  document.addEventListener('DOMContentLoaded', function () {
    const selected = document.querySelector('.selected');
    const optionsContainer = document.querySelector('.options');
    const optionsList = document.querySelectorAll('.option');
    const hiddenInput = document.getElementById('role');
    const form = document.getElementById('formLogin');

    // Dropdown logic
    selected.addEventListener('click', () => {
      optionsContainer.classList.toggle('active');
    });

    optionsList.forEach(option => {
      option.addEventListener('click', () => {
        selected.innerText = option.innerText;
        hiddenInput.value = option.innerText;
        optionsContainer.classList.remove('active');
        selected.classList.remove('input-error');
      });
    });

    document.addEventListener('click', (e) => {
      if (!e.target.closest('.custom-dropdown')) {
        optionsContainer.classList.remove('active');
      }
    });

    // Show Password toggle
    const passwordField = document.getElementById('password');
    const showCheckbox = document.getElementById('showPassword');

    showCheckbox.addEventListener('change', function () {
      passwordField.type = this.checked ? 'text' : 'password';
    });

    // Form validation
    form.addEventListener('submit', function (e) {
      if (!hiddenInput.value) {
        e.preventDefault();
        selected.classList.add('input-error');
        alert("Please select a position before logging in.");
      }
    });

    // Optional: tampilkan error dari PHP session
    <?php if (isset($_SESSION['login_error'])): ?>
      alert("<?= $_SESSION['login_error'] ?>");
      <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>
  });
</script>


</body>
</html>
