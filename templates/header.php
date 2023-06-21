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

      function isAdmin() {
        if (isset($_SESSION['email']) && $_SESSION['email'] == "admin@admin.com") {
          return true;
        }
      }
      if (isAdmin()) {
        echo '<li><a href="../views/createPackage.php">Create event</a></li>';
      }
      ?>
      <li><a href="#">Explore</a></li>
      <li><a href="../views/events.php">Events</a></li>
      <?php
      function isLoggedIn() {
        if (isset($_SESSION['user_id']) && isset($_SESSION['session_id'])) {
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