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

    <button class="submit-btn" name="login">
      <div class="spin"></div>
      <span>Submit</span>
    </button>  
        
  </form>

  <script src="../public/scripts/loginValidation.js" defer></script>
</body>
</html>