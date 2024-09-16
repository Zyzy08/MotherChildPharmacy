<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT AccountID FROM users ORDER BY AccountID ASC;"; 
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Get the last AccountID
$lastAccountID = end($data)['AccountID'];

$conn->close();

// Add the last AccountID to the response
$response = array(
    'accounts' => $data,
    'lastAccountID' => $lastAccountID
);

echo json_encode($response);
?>
