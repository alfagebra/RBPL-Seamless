<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const selected = document.querySelector('.selected');
      const optionsContainer = document.querySelector('.options');
      const optionsList = document.querySelectorAll('.option');
      const hiddenInput = document.getElementById('position');

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
    });
  </script>
</head>
<body>
  <div class="container">
    <div class="left-panel">
      <img src="../images/login_img.png" alt="Login illustration">
    </div>
    <div class="right-panel">
      <h1 class="login-title">Login!</h1>
      <form action="process_login.php" method="POST">

        <label for="position">Login as</label>
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
        <input type="hidden" name="position" id="position" required>

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
</body>
<script>
  const passwordField = document.getElementById('password');
  const showCheckbox = document.getElementById('showPassword');

  showCheckbox.addEventListener('change', function () {
    passwordField.type = this.checked ? 'text' : 'password';
  });
</script>

</html>
