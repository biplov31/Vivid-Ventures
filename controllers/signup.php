<?php

include "../config/database.php";

session_start();

function checkIfEmailExists($email, $db_conn) {
  $query = "SELECT * FROM user WHERE email = '$email';";
  $result = $db_conn->query($query);
  if ($result->num_rows > 0) {
    return true;
  }
}
if (isset($_GET['email'])) {
  $emailToVerify = $_GET['email'];
  $emailExists = checkIfEmailExists($emailToVerify, $conn);
  if ($emailExists) {
    http_response_code(409);
    echo json_encode(['error'=>true, 'message'=>'Email already exists.']);
    exit();
  }
}

$popupText = "";
$popupClasses = "hidden";

if (isset($_POST['signup'])) {
  $name = $_POST['name'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
  $dateOfBirth = $_POST['date-of-birth'];
  $gender = $_POST['gender'];

  $query = "INSERT INTO user (name, mobile_number, email, password, gender, date_of_birth)
  VALUES ('$name', '$contact', '$email', '$hashedPassword', '$gender', '$dateOfBirth')";

  if ($conn->query($query)) {
    $userId = $conn->insert_id;
    $_SESSION['user_id'] = $userId;
    $_SESSION['email'] = $email;
    $sessionId = session_id();
    $_SESSION['session_id'] = $sessionId;
    $popupText = "Sign up successful.";
    $popupClasses = "success";
    header("Location: ../public/index.php");
  } else {
    $popupText = "Error signing up.";
    $popupClasses = "failure";
    // header("Refresh: 0");
  }

  $conn->close();
}

?>
