<?php 
include "../config/database.php";

$title = $start_date = $end_date = $seats = $price = $description = $fileName = '';


if (isset($_POST['create']) || isset($_POST['update'])) {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $start_date = $_POST['start-date'];
  $end_date = $_POST['end-date'];
  if ($start_date > $end_date) {
    echo "The start date is later than the end date.";
    die();
  }
  $seats = $_POST['total-seats'];
  $price = $_POST['price'];
  $description = mysqli_real_escape_string($conn, $_POST['description']);

  $targetDir = "../public/assets/images/";
  $fileName = basename($_FILES['image']['name']);
  $targetFilePath = $targetDir . $fileName;
  
  if (isset($_POST['create'])) {
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
      $stmt = $conn->prepare("INSERT INTO packages (title, image, start_date, end_date, seats, price, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssssss", $title, $fileName, $start_date, $end_date, $seats, $price, $description);

      if ($stmt->execute()) {
        header("Location: ../views/events.php");
        echo "Data uploaded successfully.";
      } else {
        echo "Data upload failed.";
      }
    } else {
      echo "Failed to upload image.";
    }
  }

  if (isset($_POST['update']) && isset($_GET['package_id'])) {
    $packageId = $_GET['package_id'];
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
      $stmt = $conn->prepare("UPDATE packages SET title=?, image=?, start_date=?, end_date=?, seats=?, price=?, description=? WHERE package_id=?");
      $stmt->bind_param("sssssssi", $title, $fileName, $start_date, $end_date, $seats, $price, $description, $packageId);

      if ($stmt->execute()) {
        header("Location: ../views/events.php");
        echo "<div class='popup success'>Data updated successfully.</div>";
      } else {
        echo "<div class='popup success'>Failed to update data.</div>";
      }
    } else {
      echo "<div class='popup success'>Failed to upload file.</div>";
    }
  } 
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_GET['package_id'])) {
  $packageId = $_GET['package_id'];
  $stmt = $conn->prepare("DELETE FROM packages WHERE package_id = ?");
  $stmt->bind_param("i", $packageId);
  if ($stmt->execute()) {
    header("Location: ../views/events.php");
    http_response_code(204);
    echo json_encode(['message'=>'Package deleted successfully.']);
  } else {
    echo "Error deleting package: " . $stmt->error;
  }
  exit();
}

$conn->close();

// if (isset($_POST["update"])) {
//   $title = $_POST['title'];
//   $start_date = $_POST['start-date'];
//   $end_date = $_POST['end-date'];
//   if ($start_date > $end_date) {
//     echo "The start date is later than the end date.";
//     die();
//   }
//   $seats = $_POST['total-seats'];
//   $price = $_POST['price'];
//   $description = $_POST['description'];

//   $targetDir = "../public/assets/images/";
//   $fileName = basename($_FILES['image']['name']);
//   $targetFilePath = $targetDir . $fileName;
  
//   if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
//     $insert = $conn->query("INSERT INTO package (title, image, start_date, end_date, seats, price, description)
//     VALUES ('$title', '$fileName', '$start_date', '$end_date', '$seats', '$price', '$description')");

//     if ($insert) {
//       echo "Data uploaded successfully.";
//     } else {
//       echo "Data upload failed.";
//     }
//   }
// }

// if (isset($_GET['package_id'])) {
//   $packageId = $_GET['package_id'];
//   $query = "SELECT * FROM package WHERE package_id='$packageId'";
//   $result = $conn->query($query);
//   if ($result->num_rows > 0) {
//     $existingRecord = $result->fetch_assoc();
//     $title = $existingRecord['title'];
//     $start_date = $existingRecord['start_date'];
//     $end_date = $existingRecord['end_date'];
//     $seats = $existingRecord['seats'];
//     $price = $existingRecord['price'];
//     $description = $existingRecord['description'];
//     $fileName = $existingRecord['image'];
//     // header("Location: ../views/createPackage.php?package_id=$packageId&title=$title&start_date=$start_date&end-date=$end_date&seats=$seats&price=$price&description=$description&fileName=$fileName");
//   }
// }

// $packageData = array();
// // if the current date > end_date of package, it should display as unavailable for a week or so, after that it disappears
// if (isset($_GET['package_id'])) {
//   $packageId = $_GET['package_id'];
//   $query = "SELECT * FROM package WHERE package_id='$packageId'";
//   $result = $conn->query($query);
//   if ($result->num_rows > 0) {
//     $existingRecord = $result->fetch_assoc();
//     $packageData['title'] = $existingRecord['title'];
//     echo $title;
//     $packageData['start_date'] = $existingRecord['start_date'];
//     $packageData['end_date'] = $existingRecord['end_date'];
//     $packageData['seats'] = $existingRecord['seats'];
//     $packageData['price'] = $existingRecord['price'];
//     $packageData['fileName'] = $existingRecord['image'];
//     $packageData['description'] = $existingRecord['description'];
//     header("Location: ../views/createPackage.php?package_data=".urlencode(json_encode($packageData)));
//   }
// }

// function getPackageData() {
//   $packageData = array();
//   $packageData['title'] = "Yesto ni huncha tait";

//   return $packageData;
// }

?>