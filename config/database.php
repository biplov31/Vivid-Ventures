<?php
  
  $host = "localhost";
  $username = "root";
  $password = "";
  $db = "vivid-ventures";

  $conn = new mysqli($host, $username, $password, $db);

  if (!$conn) {
    die("Database connection failed: " . $conn->error);
  }
?>