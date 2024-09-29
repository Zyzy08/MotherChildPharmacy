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

// Query to get the next auto-increment value
$table = 'purchaseorders'; // Replace with your table name
$sql = "SHOW TABLE STATUS LIKE '$table'";
$result = $conn->query($sql);

$data = array();
$nextAutoIncrement = null;

if ($result && $row = $result->fetch_assoc()) {
    // The Auto_increment value is in the 'Auto_increment' field
    $nextAutoIncrement = $row['Auto_increment'];
}

// Get all AccountIDs (optional, if needed)
$sql = "SELECT PurchaseOrderID FROM $table ORDER BY PurchaseOrderID ASC"; 
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

// Add the auto-increment value to the response
$response = array(
    'accounts' => $data,
    'nextAutoIncrement' => $nextAutoIncrement
);

echo json_encode($response);
?>
