<?php
include "../config/database.php";

session_start();
// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_id'])) {
  $userId = $_GET['user_id'];
  try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id=?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
      $userDetails = $result->fetch_assoc();
      echo json_encode(['name'=>$userDetails['name'], 'mobile_number'=>$userDetails['mobile_number'], 'email'=>$userDetails['email']]);
    } else {
      echo "Error: " .  $conn->error;
    }
  } catch(Exception $error) {
    echo $error->getMessage();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = file_get_contents('php://input');
  $details = json_decode($data, true);
  $packageId = $details['packageId'];
  $userId = $details['userId'];

  $existingRegistration = $conn->query("SELECT * FROM package_registrations WHERE package_id='$packageId' AND user_id='$userId'");
  if ($existingRegistration->num_rows < 1) {
    $stmt = $conn->prepare("INSERT INTO package_registrations (package_id, user_id) VALUES (?, ?)");
    $stmt->bind_param('ii', $packageId, $userId);
    if ($stmt->execute()) {
      http_response_code(200);
      echo json_encode(['error'=>false, 'message'=>'Registration successfull.']);
      exit();
    }    
  } else {
    // header("refresh:3; url=../views/event.php?package_id=$packageId");
    http_response_code(409);
    echo json_encode(['error'=>true, 'message'=>'You have already registered for the event.']);
    exit();
    // echo "<div class='popup failure'>You have already registered for this event.</div>";
  }

  // $insert = $conn->query("INSERT INTO registrations (package_id, user_id) VALUES ('$packageId', '$userId')");
  // a trigger that checks before inserting whether the seats are all booked

  // if ($insert) {
  //   echo "<div class='popup success'>Registration successful.</div>"
  // }
}
?>