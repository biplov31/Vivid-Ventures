<?php
  
  $host = "localhost";
  $username = "root";
  $password = "";
  $db = "vivid-ventures";

  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  $conn = new mysqli($host, $username, $password, $db);

  if (!$conn) {
    die("Database connection failed: " . $conn->error);
  }
?>