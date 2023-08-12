<?php
include "../controllers/login.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['session_id'])) {
  header("Location: ../public/index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../public/assets/icons/favicon.svg" type="image/x-icon">
  <title>Vivid Ventures</title>
  <link rel="stylesheet" href="../public/styles/form.css">
</head>
<body>
  <h1>Log in</h1>
  <div class="background"></div>
  <form action="" method="POST" class="login">

    <div class="email">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" class="login-email" required>
      <!-- <p class="email-error form-error"></p> -->
    </div>

    <div class="password">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
      <!-- <p class="password-error form-error"></p> -->
    </div>

    <div class="user-type-radios">
      <label for="user">User</label>
      <input type="radio" name="type" value="user" id="user" required>
      <label for="guide">Guide</label>
      <input type="radio" name="type" value="guide" id="guide">
      <label for="admin">Admin</label>
      <input type="radio" name="type" value="admin" id="admin">
    </div>

    <span>Haven't signed up? <a href="../views/signup.php" class="extra-link">Sign up</a></span>

    <button class="submit-btn" name="login">
      <div class="spin"></div>
      <span>Submit</span>
    </button>  
        
  </form>

  <script src="../public/scripts/main.js"></script>
  <script src="../public/scripts/loginValidation.js" defer></script>
</body>
</html>