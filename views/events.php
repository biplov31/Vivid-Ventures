<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vivid Ventures</title>
  <link rel="stylesheet" href="../public/styles/style.css">
</head>
<body>
  <?php 
  include('../config/database.php');
  include('../templates/header.php');

  $query = "SELECT * FROM package ORDER BY start_date";
  $result = $conn->query($query);

  ?>

  <main>
    <h3 class="section-heading">Ongoing Events</h3>
   
    <div class="event-cards">
      <?php
      function formatDate($date) {
        return date("m/d", strtotime($date));
      }
      if ($result->num_rows > 0) {
        while($package = $result->fetch_assoc()) {
          
          echo '
          <div class="event-card">
            <img src="../public/assets/images/'.$package["image"].'" alt="">
            <strong>'.$package["title"].'</strong>
            <div class="event-card-info">
              <div class="info-text">
                <ul>
                  <li>'.formatDate($package['start_date']).' to '.formatDate($package['end_date']).'</li>
                  <li>Per head Rs '.$package['price'].'</li>
                  <li>Total spots: '.$package['seats'].'</li>
                </ul>
              </div>';
              if (isAdmin()) {
                echo '
                <a class="edit-btn event-btn" href="../views/createPackage.php?package_id='.$package['package_id'].'">Edit</a>
                <button class="delete-event-btn event-btn" value="'.$package['package_id'].'">Delete</button>
                ';
              } else {
                echo '<a class="register-btn event-btn" href="event.php?id='.$package['package_id'].'">Register</a>';
              }
            echo '
            </div>
          </div>
          ';
        }
      }
      ?>
    </div> 
  </main>
  <div class="plane animate-plane">
    <img src="./assets/images/paper-plane-regular.svg" alt="">
  </div>

  <?php include('../templates/footer.php') ?>

  <script src="../public/scripts/event.js"></script>
</body>
</html>