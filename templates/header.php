<header>
  <a href="../public/index.php"><div class="logo"></div></a>
  <div class="mobile-nav-toggle">
    <span class="bar"></span>
    <span class="bar"></span>
    <span class="bar"></span>
  </div>
  <nav class="navbar">
    <ul>
      <?php 
      session_start();
      include "../config/database.php";

      function isAdmin() {
        if (isset($_SESSION['email']) && $_SESSION['email'] == "admin@admin.com") {
          return true;
        }
      }
      if (isAdmin()) {
        echo '<li><a href="../views/createPackage.php">Create event</a></li>';
      }
      if (isset($_SESSION['guide_id'])) {
        $guideId = $_SESSION['guide_id'];
        $guideStatus = $conn->query("SELECT active FROM guides WHERE guide_id=$guideId")->fetch_assoc();
        
        echo '
        <div class="toggle-container">
          <label for="active-toggle" class="active-status-text">'. ($guideStatus['active'] == 1 ? 'Active' : 'Inactive') .'</label>
          <input type="checkbox" id="active-toggle" role="switch" name="active-status"'. ($guideStatus['active'] == 1 ? 'checked' : '') .'>
          <input type="hidden" id="guide-id" value="'. $guideId .'">
        </div>
        ';
      }
      ?>
      <li><a href="#">Explore</a></li>
      <li><a href="../views/events.php">Events</a></li>
      <?php
      function isLoggedIn() {
        if (isset($_SESSION['email']) && isset($_SESSION['session_id'])) {
          return true;
        } else {
          return false;
        }
      }
      if (isLoggedIn()) {
        echo '<li><a href="../controllers/logout.php">Logout</a></li>';
      } else {
        echo '
        <li><a href="../views/login.php">Login</a></li>
        <li><a href="../views/signup.php">Sign up</a></li>
        ';
      }
      ?>
    </ul>
  </nav>
</header>