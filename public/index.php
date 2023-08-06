<?php
  session_start();

  if (isset($_SESSION['user_id']) && isset($_SESSION['session_id'])) {
    // echo "User is logged in.";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vivid Ventures</title>
  <link rel="icon" href="./assets/icons/favicon.svg" type="image/x-icon">
  <link rel="stylesheet" href="./styles/style.css">
  <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet"> -->
</head>
<body>
  <header class="index-page-header">
    <a href="../public/index.php"><div class="logo"></div></a>
    <div class="mobile-nav-toggle">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </div>
    <nav class="navbar">
      <ul>
        <?php
          if (isset($_SESSION['email']) && $_SESSION['email'] == "admin@admin.com") {
            echo '<li><a href="../views/createPackage.php">Create event</a></li>';
          }
        ?>
        <li><a href="#">Explore</a></li>
        <li><a href="../views/events.php">Events</a></li>
        <?php
          if (isset($_SESSION['user_id']) && isset($_SESSION['session_id'])) {
            echo '<li><a href="../controllers/logout.php">Logout</a></li>';
          } else {
            echo '
            <li><a href="../views/login.php">Login</a></li>
            <li class="signup-options">
              <a href="../views/signup.php">Sign up<img src="./assets/images/arrow-drop-down-line.svg" alt=""></a>          
              <ul>
                <li>As a user</li>
                <li>As a guide</li>
              </ul>
            </li>
            ';
          }
        ?>
        
      </ul>
    </nav>
  </header>

  <section class="hero">
    <video muted loop autoplay >
      <source src="./assets/images/mountains.mp4" type="video/mp4">
    </video>
    <div class="video-container"></div>
    
    <div class="hero-content">
      <h2>Travelling is a way of life!</h2>
      <button>Start today!</button>
    </div>
  </section>

  <section class="ongoing-events">
    <h3 class="section-heading">Ongoing Events</h3>
    <div class="event-cards">
    <?php
    include "../config/database.php";
    
    $query = "SELECT * FROM packages WHERE end_date >= CURRENT_DATE() ORDER BY package_id DESC LIMIT 3";
    $result = $conn->query($query);

    function formatDate($date) {
      return date("m/d", strtotime($date));
    }
    if ($result->num_rows > 0) {
      while($package = $result->fetch_assoc()) {
        
        echo '
        <div class="event-card">
          <div class="event-card-image">
            <img src="../public/assets/images/'.$package['image'].'" alt="">
            <h4>'.$package['title'].'</h4>
          </div>  
          <div class="event-card-info">
            <div class="info-text">
              <ul>
                <li>'.(new DateTime($package['start_date']))->diff(new DateTime($package['end_date']))->days . '-day trip</li>
                <li><strong>Price:</strong> Rs. '.$package['price'].'</li>
                <li><strong>Total spots:</strong> '.$package['seats'].'</li>
              </ul>
            </div>
            <div class="event-card-buttons">
              <a class="register-btn event-card-btn" href="../views/event.php?package_id='.$package['package_id'].'">View more</a>
            </div>
          </div>
        </div>
        ';
      }
    }
    ?>
    </div>
  </section>

  <h3 class="section-heading">Need some company?</h3>
  <section class="find-company">
    <div class="find-guide">
      <a href="../views/guides.php"><p class="find-guide-txt">Travel with a guide</p></a>
      <img src="./assets/images/guide.jpg" alt="">
    </div>
    <div class="find-group">
      <p class="find-group-txt">Travel with a group of like-minded people</p>
      <img src="./assets/images/group.jpg" alt="">
    </div>
  </section>

  <h3 class="section-heading">Itinerary</h3>
  <section class="itinerary">
    <?php
    $images = array();
    $query = "SELECT image FROM packages ORDER BY RAND()";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $images[] = $row;
      }
    }
    ?>
    <div class="gallery-images">
      <div class="gallery-img img1">
        <img src="./assets/images/<?php echo $images[0]['image'] ?>" alt="">
      </div>
      <div class="gallery-img img2">
        <img src="./assets/images/<?php echo $images[1]['image'] ?>" alt="">
      </div>
      <div class="gallery-img img3">
        <img src="./assets/images/<?php echo $images[2]['image'] ?>" alt="">
      </div>
      <div class="gallery-img img4">
        <img src="./assets/images/<?php echo $images[3]['image'] ?>" alt="">
      </div>
      <div class="gallery-img img5">
        <img src="./assets/images/<?php echo $images[4]['image'] ?>" alt="">
      </div>
    </div>
  </section>

  <?php include('../templates/footer.php'); ?>

  <script src="./scripts/main.js"></script>
</body>
</html>