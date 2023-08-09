<?php
include "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = file_get_contents('php://input');
  $statusDetails = json_decode($data, true);
  $guideId = $statusDetails['guideId'];

  function updateStatus($dbConn, $activeStatus, $guideId) {
    try {
      $stmt = $dbConn->prepare("UPDATE guides SET active = ? WHERE guide_id = ?");
      $stmt->bind_param('ii', $activeStatus, $guideId);
      if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(['status'=> $activeStatus == 1 ? 'Active' : 'Inactive']);
      } else {
        echo "Error: " .  $dbConn->error;
      };      
    } catch(Exception $error) {
      echo $error->getMessage();
    }
  }
  if ($statusDetails['active'] == true) {
    updateStatus($conn, 1, $guideId);
  }
  if ($statusDetails['active'] == false) {
    updateStatus($conn, 0, $guideId);
  }
}
?>