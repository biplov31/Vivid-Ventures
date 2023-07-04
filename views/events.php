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

  $query = "SELECT * FROM packages ORDER BY start_date";
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
        $expiredPackages = [];
        while($package = $result->fetch_assoc()) {
          if ($package['end_date'] < date('Y-m-d')) {
            array_push($expiredPackages, $package);
            continue;
          }
          echo '
          <div class="event-card">
            <div class="event-card-image">
              <img src="../public/assets/images/'.$package['image'].'" alt="">
              <strong>'.$package['title'].'</strong>
            </div>  
            <div class="event-card-info">
              <div class="info-text">
                <ul>
                  <li>'.formatDate($package['start_date']).' to '.formatDate($package['end_date']).'</li>
                  <li>Per head Rs '.$package['price'].'</li>
                  <li>Total spots: '.$package['seats'].'</li>
                </ul>
              </div>
              <div class="event-card-buttons">';
              if (isAdmin()) {
                echo '
                <a class="edit-btn event-card-btn" href="../views/createPackage.php?package_id='.$package['package_id'].'">Edit</a>
                <button class="delete-event-btn event-card-btn" value="'.$package['package_id'].'">Delete</button>                 
                ';
              } else {
                echo '<a class="register-btn event-card-btn" href="../views/event.php?package_id='.$package['package_id'].'">View more</a>';
              }
              echo '
              </div> 
            </div>
          </div>
          ';
        }
        foreach ($expiredPackages as $package) {
          echo '
          <div class="event-card">
            <span class="expired-text">Expired</span>
            <div class="expired-event"></div>
            <div class="event-card-image">
              <img src="../public/assets/images/'.$package['image'].'" alt="">
              <strong>'.$package['title'].'</strong>
            </div>  
            <div class="event-card-info">
              <div class="info-text">
                <ul>
                  <li>'.formatDate($package['start_date']).' to '.formatDate($package['end_date']).'</li>
                  <li>Price: Rs. '.$package['price'].'</li>
                  <li>Total spots: '.$package['seats'].'</li>
                </ul>
              </div>
              <div class="event-card-buttons">
                <a class="register-btn event-card-btn">View more</a>
              </div> 
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

  <script src="../public/scripts/events.js"></script>
  <script src="../public/scripts/main.js"></script>
</body>
</html>