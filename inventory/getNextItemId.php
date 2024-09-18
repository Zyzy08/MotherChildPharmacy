<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Retrieve the next auto-increment value
$sql = "SHOW TABLE STATUS LIKE 'inventory'";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $nextItemID = $row['Auto_increment'];
    echo json_encode(['success' => true, 'nextItemID' => $nextItemID]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error retrieving next ItemID']);
}

$conn->close();
?>
