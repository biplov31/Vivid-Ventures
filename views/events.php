<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vivid Ventures - Events</title>
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

  $currentUrl = $_SERVER['REQUEST_URI'];
  // we want to preserve the existing query parameters in the URL by appending new parameters to them instead of overwriting them
  function addUrlParam($url, $newParams) {
    $existingParamStr = parse_url($url, PHP_URL_QUERY);
    parse_str($existingParamStr, $existingParams);
    if (!isset($newParams['order']) && !isset($newParams['page'])) {
      unset($existingParams['order']);
    }
    $updatedParams = array_merge($existingParams, $newParams); // if a different value is passed for the same key, we want to replace the previous value with the new one and also include new key-value pairs if any
    $queryString = http_build_query($updatedParams);
    $baseUrl = $_SERVER['PHP_SELF'];
    // if ($existingParamStr) {
    //   return $baseUrl .= '&' . $queryString;
    // } else {
    //   return $baseUrl .= '?' . $queryString;
    // }

    return $baseUrl . '?' . $queryString;
  }

  $recordsPerPage = 6;
  $currentPageNum = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $startingPosition = $recordsPerPage * ($currentPageNum - 1);
  $query = null;
  // we need to display the unexpired events first and then expired events after that
  if (isset($_GET['sortby'])) {
    $sortingCondition = $_GET['sortby'] ?? '';
    $order = $_GET['order'] ?? '';
    $query = "SELECT * FROM (
      SELECT *, DATEDIFF(end_date, start_date) AS duration, 1 AS sorting_order FROM packages WHERE end_date >= CURRENT_DATE()
      UNION
      SELECT *, DATEDIFF(end_date, start_date) AS duration, 2 AS sorting_order FROM packages WHERE end_date < CURRENT_DATE()
      ) AS total_packages ORDER BY sorting_order, $sortingCondition $order LIMIT $recordsPerPage OFFSET $startingPosition;";
  } else {
    $query = "SELECT * FROM (
      SELECT * FROM packages WHERE end_date >= CURRENT_DATE()
      UNION
      SELECT * FROM packages WHERE end_date < CURRENT_DATE()
    ) AS total_packages ORDER BY package_id DESC LIMIT $recordsPerPage OFFSET $startingPosition;";
  }
  try {
    $result = $conn->query($query);
  } catch (mysqli_sql_exception $e) {
    var_dump($e);
  }

  ?>

  <main>
    <div class="heading-container">
      <h3 class="section-heading">Our Events</h3>
      <div class="sort-container">
        <button class="sort-btn">Sort by
          <span class="arrow-icon">
            <img src="../public/assets/icons/arrow-drop-down-line.svg" alt="">
          </span>
        </button>
        <ul class="sorting-options">
          <li><a href="<?php echo addUrlParam($currentUrl, ['sortby'=>'price']); ?>">Price</a></li>
          <li><a href="<?php echo addUrlParam($currentUrl, ['sortby'=>'duration', 'order'=>'asc']); ?>">Duration (Low to high)</a></li>
          <li><a href="<?php echo addUrlParam($currentUrl, ['sortby'=>'duration', 'order'=>'desc']); ?>">Duration (High to low)</a></li>
          <li><a href="<?php echo addUrlParam($currentUrl, ['sortby'=>'seats']); ?>">Seats</a></li>
        </ul>
      </div>
    </div>
   
    <section class="events">

        <div class="event-cards">
          <?php
          function formatDate($date) {
            return date("m/d", strtotime($date));
          }
    
          $totalRecords = $conn->query("SELECT * FROM packages")->num_rows;
          $totalPages = ceil($totalRecords / $recordsPerPage);
    
          if ($totalRecords) {
            while($package = $result->fetch_assoc()) {
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
          }
          ?>
        </div> 
        <div class="page-info-container">
          <a href="<?php echo addUrlParam($currentUrl, array('page'=>$currentPageNum - 1)) ?>" class="prev-btn">Previous</a>
          <?php
          for ($i = 1; $i <= $totalPages && $i < 5; $i++) {
            echo "<a href='".addUrlParam($currentUrl, array('page'=>$i))."' class=".($i == $currentPageNum ? 'active-page' : '').">$i</a>";
          }
          ?>
          <a href="<?php echo addUrlParam($currentUrl, array('page'=>$currentPageNum + 1)) ?>" class="next-btn">Next</a>
        </div>
      </main>
    </section>

  <?php include('../templates/footer.php') ?>

  <script src="../public/scripts/events.js"></script>
  <script src="../public/scripts/main.js"></script>
</body>
</html>