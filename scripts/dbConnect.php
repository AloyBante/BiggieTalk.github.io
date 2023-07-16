<?php
//$servername = "127.0.0.1:3306";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oabeldb";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die(json_encode(array('message' => $conn->connect_error, 'success' => false)));
}
else {
  echo json_encode(array('message' => 'Connected successfully', 'success' => true));
}

?>