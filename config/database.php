<?php
  
  $host = "localhost";
  $username = "root";
  $password = "";
  $db = "vivid-ventures";

  $conn = new mysqli($host, $username, $password, $db);

  if ($conn) {
    // echo "Connection successful.";
    return;
  } else {
    echo $conn->connect_error;
  }
?>