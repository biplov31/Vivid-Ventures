<?php
include "../config/database.php";

session_start();

if (isset($_POST['login'])) {
  var_dump( basename($_SERVER['HTTP_REFERER']));
  $email = $_POST['email'];
  $password = $_POST['password'];

  // if a person has the same email and password in both the users and guides tables, it creats confusion. we can have different login forms or select through a radio button
  // if package.end_data < date.today, grayed out, expired
  // sort events on the basis of cost/date/number of days
  function checkTable($table, $email) {
    $query = "SELECT * FROM $table WHERE email='$email' AND password='$password'";
  }
  
  $query = "SELECT * FROM users WHERE email='$email'";
  $result = $conn->query($query);
  if ($result->num_rows > 0) {
    $record = $result->fetch_assoc();
    if (password_verify($password, $record['password'])) {
      $sessionId = session_id();
      $_SESSION['session_id'] = $sessionId;
      $_SESSION['user_id'] = $record['user_id'];
      $_SESSION['email'] = $record['email'];
      header("Location: ../public/index.php");
    } else {
      echo "<div class='popup failure'>Error logging in. Make sure the password is correct.</div>";
    };
  } else {
    echo "<div class='popup failure'>Email not found. Please sign up first.</div>";
    // header("Refresh: 0");
    // echo "<div class='popup failure'>Email not found.</div>";
    // http_response_code(409);
    // echo json_encode(['error'=>true, 'message'=>"Email not found. Please sign up first."]);
    // exit(); 
  }
  $conn->close();
}
?>