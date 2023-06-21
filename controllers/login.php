<?php
include "../config/database.php";
// include "../views/login.php";

session_start();

$popupText = "";
$popupClasses = "hidden";
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  $query = "SELECT * FROM user WHERE email='$email'";
  $result = $conn->query($query);
  if ($result->num_rows > 0) {
    $record = $result->fetch_assoc();
    if (password_verify($password, $record['password'])) {
      $sessionId = session_id();
      $_SESSION['session_id'] = $sessionId;
      $_SESSION['user_id'] = $record['user_id'];
      $_SESSION['email'] = $record['email'];
      $popupText = "Logged in successfully.";
      $popupClasses = "success";
      header("Location: ../public/index.php");
    } else {
      $popupText = "Error logging in. Make sure the password is correct.";
      $popupClasses = "failure";
    };
  } else {
    $popupText = "Email not found. Please sign up first.";
    $popupClasses = "failure";
    // header("Refresh: 0");
    // echo "<div class='popup failure'>Email not found.</div>";
    // http_response_code(409);
    // echo json_encode(['error'=>true, 'message'=>"Email not found. Please sign up first."]);
    // exit(); 
  }
  $conn->close();
}
?>