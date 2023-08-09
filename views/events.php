<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vivid Ventures</title>
  <link rel="icon" href="../public/assets/icons/favicon.svg" type="image/x-icon">
  <link rel="stylesheet" href="../public/styles/style.css">
</head>
<body>
  <?php 
  include('../config/database.php');
  include('../templates/header.php');

  // CREATE TEMPORARY TABLE unexpired AS SELECT * FROM packages WHERE end_date >= CURRENT_DATE();
  // create temporary table expired as select * from packages where end_date < CURRENT_DATE();

  // SELECT * FROM unexpired
  // UNION
  // select * from expired;
  
  // $query = "SELECT * FROM (
    //   SELECT * FROM packages WHERE end_date >= CURRENT_DATE() ORDER BY $param
    //   )
    //   UNION ALL
    //   SELECT * FROM packages WHERE end_date < CURRENT_DATE()
    //   ";

  $query = null;
  if (isset($_GET['sortby'])) {
    $param = $_GET['sortby'];
    $order = $_GET['order'] ?? '';
    $query = "SELECT * FROM (
      SELECT *, DATEDIFF(end_date, start_date) AS duration, 1 AS sorting_order FROM packages WHERE end_date >= CURRENT_DATE()
      UNION
      SELECT *, DATEDIFF(end_date, start_date) AS duration, 2 AS sorting_order FROM packages WHERE end_date < CURRENT_DATE()
      ) AS total_packages ORDER BY sorting_order, $param $order";
  } else {
    $query = "SELECT * FROM (
      SELECT * FROM packages WHERE end_date >= CURRENT_DATE()
      UNION
      SELECT * FROM packages WHERE end_date < CURRENT_DATE()
    ) AS total_packages ORDER BY package_id DESC;";
  }
  try {
    $result = $conn->query($query);
  } catch (mysqli_sql_exception $e) {
    var_dump($e);
  }

  ?>

  <main>
    <div class="heading-container">
      <h3 class="section-heading">Ongoing Events</h3>
      <div class="sort-container">
        <button class="sort-btn">Sort by
          <span class="arrow-icon">
            <img src="../public/assets/icons/arrow-drop-down-line.svg" alt="">
          </span>
        </button>
        <ul class="sorting-options">
          <a href="?sortby=price"><li>Price</li></a>
          <li><a href="?sortby=duration&order=asc">Duration (Low to high)</a></li>
          <li><a href="?sortby=duration&order=desc">Duration (High to low)</a></li>
          <a href="?sortby=seats"><li>Seats</li></a>
        </ul>
      </div>
    </div>
   
    <div class="event-cards">
      <?php
      function formatDate($date) {
        return date("m/d", strtotime($date));
      }
      if ($result->num_rows > 0) {
        $expiredPackages = [];
        while($package = $result->fetch_assoc()) {
          // if ($package['end_date'] < date('Y-m-d')) {
          //   array_push($expiredPackages, $package);
          //   continue;
          // }
          echo '
          <div class="event-card">'.
          (($package['end_date'] < date('Y-m-d')) && isset($_SESSION['email']) && $_SESSION['email'] !== 'admin@admin.com' ? "<div class='expired-event'></div><span class='expired-text'>Expired</span>" : "") .'
            <div class="event-card-image">
              <img src="../public/assets/images/'.$package['image'].'" alt="">
              <h4>'.$package['title'].'</h4>
            </div>  
            <div class="event-card-info">
              <div class="info-text">
                <ul>
                  <li><strong>'.(new DateTime($package['start_date']))->diff(new DateTime($package['end_date']))->days.'-day trip</strong></li>
                  <li><strong>Price</strong>: Rs '.$package['price'].'</li>
                  <li><strong>Total seats</strong>: '.$package['seats'].'</li>
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
        // foreach ($expiredPackages as $package) {
        //   echo '
        //   <div class="event-card">
        //     <span class="expired-text">Expired</span>
        //     <div class="expired-event"></div>
        //     <div class="event-card-image">
        //       <img src="../public/assets/images/'.$package['image'].'" alt="">
        //       <strong>'.$package['title'].'</strong>
        //     </div>  
        //     <div class="event-card-info">
        //       <div class="info-text">
        //         <ul>
        //           <li>'.formatDate($package['start_date']).' to '.formatDate($package['end_date']).'</li>
        //           <li>Price: Rs. '.$package['price'].'</li>
        //           <li>Total spots: '.$package['seats'].'</li>
        //         </ul>
        //       </div>
        //       <div class="event-card-buttons">
        //         <a class="register-btn event-card-btn">View more</a>
        //       </div> 
        //     </div>
        //   </div>
        //   ';
        // }
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