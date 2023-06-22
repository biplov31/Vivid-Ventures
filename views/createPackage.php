<?php 
include "../config/database.php";
include "../controllers/managePackage.php";

// $package = getPackageData();
// echo $package['title'];
$updatePackage = false;
if (isset($_GET['package_id'])) {
  $packageId = $_GET['package_id'];
  global $updatePackage;
  $updatePackage = true;
  $query = "SELECT * FROM packages WHERE package_id='$packageId'";
  $result = $conn->query($query);
  if ($result->num_rows > 0) {
    $existingRecord = $result->fetch_assoc();
    $title = $existingRecord['title'];
    $start_date = $existingRecord['start_date'];
    $end_date = $existingRecord['end_date'];
    $seats = $existingRecord['seats'];
    $price = $existingRecord['price'];
    $description = $existingRecord['description'];
    $fileName = $existingRecord['image'];
  }
}

// if (isset($_GET['package_data'])) {
//   $title = $_GET['title'];
//   $start_date = $_GET['start_date'];
//   $end_date = $_GET['end_date'];
//   $seats = $_GET['seats'];
//   $price = $_GET['price'];
//   $description = $_GET['description'];
//   $fileName = $_GET['fileName'];
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vivid Ventures</title>
  <link rel="stylesheet" href="../public/styles/form.css">
</head>
<body>
  <div class="background"></div>
  <h1><?php echo $updatePackage ? "Update Event" : "Create Event" ?></h1>
  <form action="<?php if ($updatePackage) echo "../controllers/managePackage.php?package_id=$packageId" ?>" method="POST" class="event-form" enctype="multipart/form-data">
    <div class="event-title">
      <label for="title">Title:</label>
      <input type="text" name="title" id="title" value="<?php echo $title ?>" required>
    </div>
    <div class="event-image">
      <label for="image">Image:</label>
      <input type="file" name="image" id="image" accept="image/*" value="<?php echo $fileName ?>" required>
    </div>
    <div class="start-date">
      <label for="start-date">Start date:</label>
      <input type="date" name="start-date" id="start-date" value="<?php echo $start_date ?>">
    </div>
    <div class="end-date">
      <label for="end-date">End date:</label>
      <input type="date" name="end-date" id="end-date" value="<?php echo $end_date ?>">
    </div>
    
    <div class="total-seats">
      <label for="total-seats">Total seats:</label>
      <input type="number" name="total-seats" id="total-seats" value="<?php echo $seats ?>">
    </div>
    
    <div class="price">
      <label for="price">Price:</label>
      <input type="text" name="price" id="price" value="<?php echo $price ?>">
    </div>

    <div class="event-description">
      <label for="event-description">Description:</label>
      <textarea name="description" id="event-description"><?php echo $description ?></textarea>
    </div>

    <button class="submit-btn" name=<?php echo $updatePackage ? "update" : "create" ?>>
      <div class="spin"></div>
      <span><?php echo $updatePackage ? "Update" : "Create" ?></span>
    </button>      
    <!-- users can add places to their wishlist and based on that, groups can be recommended -->
  </form>
    
</body>
</html>