<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vivid Ventures</title>
  <link rel="icon" href="../public/assets/icons/favicon.svg" type="image/x-icon">
  <link rel="stylesheet" href="../public/styles/style.css">
  <link rel="stylesheet" href="../public/styles/guide.css">
</head>
<body>
  <?php
  include "../config/database.php";
  include "../templates/header.php";

  $read = "SELECT * FROM guides";
  $results = $conn->query($read);

  
  
  ?>  

<h2 class="section-heading">Our Guides</h2>
<div class="profile-container">
  <?php
  if ($results->num_rows > 0) {
    while ($guide = $results->fetch_assoc()) {
      echo '
      <div class="guide-profile">
        <div class="status active">Active</div>
        <div class="guide-image">
          <img src="../public/assets/icons/'.($guide['gender'] == 'male' ? 'business-man-2.svg' : 'business-woman-2.svg').'" alt="">
        </div>
        <div class="guide-info"> 
          <h4>'.$guide['name'].'</h4>
          <div class="contact">
            <img src="../public/assets/icons/call-start.svg" alt="">
            <span>'.$guide['contact'].'</span>
          </div>
          <p>'.$guide['bio'].'</p> 
        </div>
      </div>
      ';
    };
  }
  ?>
  <!-- 
    <div class="guide-profile">
      <div class="status active">Active</div>
      <div class="guide-image">
        <img src="../public/assets/images/business-woman-2.svg" alt="">
      </div>
      <div class="guide-info"> 
        <h4>Tilgidi Timsina</h4>
        <div class="contact">
          <img src="../public/assets/images/call-start.svg" alt="">
          <span>9841879123</span>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga, cupiditate veniam accusantium dignissimos ipsa nam quaerat reprehenderit natus placeat qui.</p> 
      </div>
    </div>
    <div class="guide-profile">
      <div class="status active">Active</div>
      <div class="guide-image">
        <img src="../public/assets/images/business-man-2.svg" alt="">
      </div>
      <div class="guide-info"> 
        <h4>Hari Styles</h4>
        <div class="contact">
          <img src="../public/assets/icons/call-start.svg" alt="">
          <span>9856123972</span>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p> 
      </div>
    </div> -->
  </div>

  <?php include('../templates/footer.php') ?>

  <script src="../public/scripts/main.js"></script>
</body>
</html>