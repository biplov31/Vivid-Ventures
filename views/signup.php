<?php
include "../controllers/signup.php"
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
  <div class="background"></div>
  <h1>Sign up</h1>
  <form action="../controllers/signup.php" method="POST">
    <div class="popup <?php echo $popupClasses ?>"><?php echo $popupText ?></div>
    <div class="name">
      <label for="name">Name:</label>
      <input type="text" name="name" id="name" required>
    </div>
    <div class="contact">
      <label for="contact">Mobile number:</label>
      <input type="text" name="contact" id="contact" required>
    </div>
    
    <div class="email">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" required>
    </div>
    
    <div class="password">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
    </div>
    <div class="confirm-password">
      <label for="rePassword">Confirm password:</label>
      <input type="password" name="rePassword" id="rePassword" required>
    </div>

    <div class="date-of-birth">
      <label for="date-of-birth">Date of birth:</label>
      <input type="date" name="date-of-birth" id="date-of-birth" required>
    </div>
    <div>
      <label>Gender:</l>
      <div class="gender-radios">
        <label for="male">Male</label>
        <input type="radio" name="gender" value="male" id="male" required>
        <label for="female">Female</label>
        <input type="radio" name="gender" value="female" id="female">
        <label for="other">Other</label>
        <input type="radio" name="gender" value="other" id="other">
      </div>
    </div>

    <div class="form-button">
      <button class="submit-btn" name="signup">
        <div class="spin"></div>
        <span>Submit</span>
      </button>      
    </div>
    <!-- users can add places to their wishlist and based on that, groups can be recommended -->
  </form>
    
  <script src="../public/scripts/formValidation.js"></script>
</body>
</html>