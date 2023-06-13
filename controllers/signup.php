<?php

include "../config/database.php";

function checkEmailDuplication($email, $db_conn) {
  $query = "SELECT * FROM user WHERE email = '$email';";
  $result = $db_conn->query($query);
  if ($result->num_rows > 0) {
    return true;
  }
}
if (isset($_GET['email'])) {
  $emailToVerify = $_GET['email'];
  $emailExists = checkEmailDuplication($emailToVerify, $conn);
  if ($emailExists) {
    http_response_code(409);
    echo json_encode(['error'=>true, 'message'=>"Email already exists."]);
    exit();
  }
}

$popupText = "Sign up successful.";
$popupClasses = "hidden";

if (isset($_POST['signup'])) {
  $name = $_POST['name'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $rePassword = $_POST['rePassword'];
  $dateOfBirth = $_POST['date-of-birth'];
  $gender = $_POST['gender'];

  $query = "INSERT INTO user (name, mobile_number, email, password, gender, date_of_birth)
  VALUES ('$name', '$contact', '$email', '$password', '$gender', '$dateOfBirth')";

  if ($conn->query($query) === true) {
    $popupText = "Sign up successful.";
    $popupClasses = "success";
    header("Location: ../public/index.php");
  } else {
    $popupText = "Error signing up.";
    $popupClasses = "failure";
    header("Refresh: 0");
  }
}

?>
