<?php
include "../config/database.php";

session_start();
// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_id'])) {
  // $data = file_get_contents('php://input');
  // $details = json_decode($data);
  // echo $details;
  $userId = $_GET['user_id'];
  try {
    $result = $conn->query("SELECT * FROM users WHERE user_id='$userId'");
  } catch(Exception $error) {
    echo $error->getMessage();
  }
  if ($result->num_rows > 0) {
    $userDetails = $result->fetch_assoc();
    echo json_encode(['name'=>$userDetails['name'], 'mobile_number'=>$userDetails['mobile_number'], 'email'=>$userDetails['email']]);
  } else {
    echo "Error: " .  $conn->error;
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['package_id'])) {
  $packageId = $_GET['package_id'];
  $userId = $_SESSION['user_id'];
  // $totalSeats = $conn->query("SELECT seats FROM packages WHERE package_id='$packageId'")->fetch_assoc();
  // $bookedSeatsResult = $conn->query("SELECT package_id, count(*) AS BookedSeatsCount FROM package_registrations WHERE package_id='$packageId' GROUP BY package_id");
  // $bookedSeats = $bookedSeatsResult->fetch_assoc();
  // $availableSeats = $totalSeats['seats'] - ($bookedSeats['BookedSeatsCount'] ?? 0);
  $existingRegistration = $conn->query("SELECT * FROM package_registrations WHERE package_id='$packageId' AND user_id='$userId'");
  if ($existingRegistration->num_rows < 1) {
    $booking = $conn->query("INSERT INTO package_registrations (package_id, user_id) VALUES ('$packageId', '$userId')");
    if ($booking) {
      header("refresh:3; url=../views/event.php?package_id=$packageId");
      echo "<div class='popup success'>Registration successful.</div>"; // since we have not imported the css in this file, styles won't be applied 
    }    
  } else {
    echo "You have already registered for this event.";
  }
  // print_r($totalSeats);
  // $insert = $conn->query("INSERT INTO registrations (package_id, user_id) VALUES ('$packageId', '$userId')");
  // a trigger that checks before inserting whether the seats are all booked

  // if ($insert) {
  //   echo "<div class='popup success'>Registration successful.</div>"
  // }
}
?>