<?php

include "../config/database.php";

session_start();

function checkIfEmailExists($table, $email, $db_conn) {
  $query = "SELECT * FROM $table WHERE email = '$email';";
  $result = $db_conn->query($query);
  if ($result->num_rows > 0) {
    return true;
  }
}
if (isset($_GET['email'])) {
  $formType = $_GET['form_type'];
  $emailToVerify = $_GET['email'];
  $emailExists = checkIfEmailExists($formType == 'signup-user' ? 'users' : 'guides', $emailToVerify, $conn);
  if ($emailExists) {
    http_response_code(409);
    echo json_encode(['error'=>true, 'message'=>'Email already exists.']);
    exit();
  }
}

if (isset($_POST['signup-user']) || isset($_POST['signup-guide'])) {
  $name = $_POST['name'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
  $dateOfBirth = $_POST['date-of-birth'];
  $gender = $_POST['gender'];

  $insert = null;
  if (isset($_POST['signup-user'])) {
    $insert = "INSERT INTO users (name, mobile_number, email, password, gender, date_of_birth)
    VALUES ('$name', '$contact', '$email', '$hashedPassword', '$gender', '$dateOfBirth')";
  }
  if (isset($_POST['signup-guide'])) {
    $bio = $_POST['bio'];
    $insert = "INSERT INTO guides (name, contact, gender, email, password, date_of_birth, bio) 
    VALUES ('$name', '$contact', '$gender', '$email', '$password', '$dateOfBirth', '$bio')";
  }

  if ($conn->query($insert)) {
    $id = $conn->insert_id;
    if (isset($_POST['signup-user'])) {
      $_SESSION['user_id'] = $id;
    } elseif (isset($_POST['signup-guide'])) {
      $_SESSION['guide_id'] = $id;
    } else {
      return;
    }
    $_SESSION['email'] = $email;
    $sessionId = session_id();
    $_SESSION['session_id'] = $sessionId;
    echo "<div class='popup success'>Signed up successfully.</div>";
    // header("Location: ../public/index.php");
    header("refresh:3; url=../public/index.php");
  } else {
    echo "<div class='popup failure'>Error signing up.</div>";
    // header("Refresh: 0");
  }

  $conn->close();
}

?>
