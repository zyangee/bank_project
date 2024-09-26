<?php
include "../dbconn.php";

// Get the username from the request
$data = json_decode(file_get_contents('php://input'), true);
$userid = $data['userid'];

// Check if the username exists
$sql = "SELECT * FROM users WHERE userid='$userid'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$response = array();
$response['exists'] = ($stmt->rowCount() > 0);

echo json_encode($response);

$conn = null;
exit();
?>