<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vivid Ventures</title>
  <link rel="icon" href="../public/assets/icons/favicon.svg" type="image/x-icon">
  <link rel="stylesheet" href="../public/styles/style.css">
  <link rel="stylesheet" href="../public/styles/event.css">
</head>
<body>
  <?php 
  include "../config/database.php";
  include "../templates/header.php";
  
  if (isset($_GET['package_id'])) {
    $packageId = $_GET['package_id'];
    // even if there are no registrations, we will still get the package details from the packages table, but if there are registrations, we will get details about both the package and the users who registered
    $read = "SELECT p.package_id, p.title, p.image, p.start_date, p.end_date, p.seats, p.price, p.description, u.name, r.registered_at
    FROM packages p
    LEFT JOIN package_registrations r ON r.package_id = p.package_id
    LEFT JOIN users u ON r.user_id = u.user_id WHERE p.package_id='$packageId'";
    $result = $conn->query($read);

    $packages = array();
    if ($result->num_rows > 0) {
      while ($registeredPackage = $result->fetch_assoc()) {
        $packages[] = $registeredPackage;
      }
    }

    $bookedSeatsResult = $conn->query("SELECT package_id, count(*) AS BookedSeatsCount FROM package_registrations WHERE package_id='$packageId' GROUP BY package_id");
    $bookedSeats = $bookedSeatsResult->fetch_assoc();
    $availableSeats = $packages[0]['seats'] - ($bookedSeats['BookedSeatsCount'] ?? 0);
  }

  function formatDate($date) {
    return date("m/d", strtotime($date));
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
        <img src="../public/assets/images/<?php echo $packages[0]['image'] ?>" alt="">
        <div class="event-info">
          <h3><?php echo $packages[0]['title'] ?></h3>
          <ul>
            <li><?php echo formatDate($packages[0]['start_date']).' to '.formatDate($packages[0]['end_date']) . ' (' . (new DateTime($packages[0]['start_date']))->diff(new DateTime($packages[0]['end_date']))->days . '-day trip)' ?></li>
            <li><strong>Price:</strong> Rs. <?php echo $packages[0]['price'] ?></li>
            <li><strong>Total seats:</strong> <?php echo $packages[0]['seats'] ?></li>
            <li><strong>Available seats:</strong> <?php echo $availableSeats ?></li>
          </ul>
        </div>
      </div>
      <div class="event-description">
        <p><?php echo $packages[0]['description'] ?></p>
      </div>            
      <button class="register-btn event-card-btn <?php echo $availableSeats >= 1 ? '' : 'disabled-btn' ?>" value="<?php echo $_SESSION['user_id'] ?? '' ?>">Register now</button>   
      <div class="registered-users">
        <strong>Registered Users &#127881;</strong>
        <?php 
        if ($packages[0]['name']) {
          foreach ($packages as $package) {
            echo "<div><span>".$package['name']."</span><span>".$package['registered_at']."</span></div>";
          }
        } else {
          echo "<p>Be the first to register for this event!</p>";
        }
        // action="../controllers/packageRegistration.php?package_id=<?php echo $packages[0]['package_id'] "
        ?>
      </div>
    </section>
    <div class="form-overlay">
      <div class="registration-form-container">
        <p>Confirm registration with following details?</p>
        <form method="POST" action="" class="registration-form"> 
          <input type="hidden" id="package-title" name="package_title" value="<?php echo $packages[0]['title'] ?>">   
          <input type="hidden" id="package-id" name="package_id" value="<?php echo $packages[0]['package_id'] ?>">   
          <input type="hidden" id="user-id" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">   
          <label>Name: <input type="text" name="name" id="name"></label>
          <label>Mobile number: <input type="text" name="contact" id="contact"></label>
          <label>Email: <input type="email" name="email" id="email"></label>
          <div class="form-buttons">
            <button class="confirm-register-btn" name="register-event" type="submit">Confirm</button>             
            <button class="cancel-btn" type="button">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include "../templates/footer.php" ?>


  <script src="../public/scripts/event.js"></script>
  <script src="../public/scripts/main.js"></script>
</body>
</html>