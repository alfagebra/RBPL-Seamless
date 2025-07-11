<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
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
      min-height: 100vh;
    }

    .container {
      display: flex;
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      width: 90%;
      max-width: 900px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      height: 505px; /* sama seperti login */
    }

    .left-panel {
      flex: 1;
      background-color: #3B0000;
      display: flex;
      justify-content: center;
      align-items: center;
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
      justify-content: flex-start;
      overflow-y: auto;
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
    input[type="email"],
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

    .login-link {
      margin-top: 10px;
      font-size: 14px;
      text-align: center;
    }

    .login-link a {
      color: #3B0000;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    @media screen and (max-width: 768px) {
      .container {
        flex-direction: column;
        height: auto;
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
      <img src="../image/img_login.png" alt="Register illustration">
    </div>
    <div class="right-panel">
      <h1 class="login-title">Register</h1>
      <form action="register_proses.php" method="POST">
        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" placeholder="Enter your full name" required>

        <label for="company">Company</label>
        <input type="text" name="company" id="company" placeholder="Enter your company name" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Enter your email address" required>

        <label for="role">Register as</label>
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

        <button type="submit">Register</button>

        <div class="login-link">
          Already have an account? <a href="login.php">Login here</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const selected = document.querySelector('.selected');
      const optionsContainer = document.querySelector('.options');
      const optionsList = document.querySelectorAll('.option');
      const hiddenInput = document.getElementById('role');

      selected.addEventListener('click', () => {
        optionsContainer.classList.toggle('active');
      });

      optionsList.forEach(option => {
        option.addEventListener('click', () => {
          selected.innerText = option.innerText;
          hiddenInput.value = option.innerText;
          optionsContainer.classList.remove('active');
        });
      });

      document.addEventListener('click', (e) => {
        if (!e.target.closest('.custom-dropdown')) {
          optionsContainer.classList.remove('active');
        }
      });

      const passwordField = document.getElementById('password');
      const showCheckbox = document.getElementById('showPassword');

      showCheckbox.addEventListener('change', function () {
        passwordField.type = this.checked ? 'text' : 'password';
      });
    });
  </script>
</body>
</html>
