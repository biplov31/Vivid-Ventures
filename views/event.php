<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vivid Ventures</title>
  <link rel="stylesheet" href="../public/styles/style.css">
  <link rel="stylesheet" href="../public/styles/event.css">
</head>
<body>
  <?php 
  include "../config/database.php";
  include "../templates/header.php";
  
  if (isset($_GET['package_id'])) {
    $packageId = $_GET['package_id'];
    $read = "SELECT * FROM packages WHERE package_id='$packageId'";
    $result = $conn->query($read);
    if ($result->num_rows > 0) {
      $package = $result->fetch_assoc();
    }

    $totalSeats = $conn->query("SELECT seats FROM packages WHERE package_id='$packageId'")->fetch_assoc();
    $bookedSeatsResult = $conn->query("SELECT package_id, count(*) AS BookedSeatsCount FROM package_registrations WHERE package_id='$packageId' GROUP BY package_id");
    $bookedSeats = $bookedSeatsResult->fetch_assoc();
    $availableSeats = $totalSeats['seats'] - ($bookedSeats['BookedSeatsCount'] ?? 0);
  }
 
  // function checkUser() {
  //   if (!$_SESSION['user_id'] && $_SESSION['guide-id']) {
  //     echo "<div>You have to sign up as a user to register for events.</div>";
  //   }
  // }
  ?>

  <div class="event-container">
    <section class="event-info-section">
        <div class="image-container">
          <img src="../public/assets/images/<?php echo $package['image'] ?>" alt="">
          <div class="event-info">
            <h3><?php echo $package['title'] ?></h3>
            <ul>
              <li><?php echo (new DateTime($package['start_date']))->diff(new DateTime($package['end_date']))->days ?>-day trip</li>
              <li>Per head Rs <?php echo $package['price'] ?></li>
              <li>Total spots: <?php echo $package['seats'] ?></li>
              <li>Available spots: <?php echo $availableSeats ?></li>
            </ul>
          </div>
        </div>
        <div class="event-description">
          <p><?php echo $package['description'] ?></p>
          <button class="register-btn event-card-btn <?php echo $availableSeats >= 1 ? '' : 'disabled-btn' ?>" value="<?php echo $_SESSION['user_id'] ?? '' ?>">Register now</button>   
        </div>            
    </section>
    <div class="form-overlay">
      <div class="registration-form-container">
        <p>Confirm registration with following details?</p>
        <form method="POST" action="../controllers/packageRegistration.php?package_id=<?php echo $package['package_id'] ?>" class="registration-form">    
          <label>Name: <input type="text" name="name" id="name"></label>
          <label>Mobile number: <input type="text" name="contact" id="contact"></label>
          <label>Email: <input type="email" name="email" id="email"></label>
          <div class="form-buttons">
            <button class="confirm-register-btn" name="register-event">Confirm</button>             
            <button class="cancel-btn" type="button">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include "../templates/footer.php" ?>


  <script src="../public/scripts/event.js"></script>
</body>
</html>