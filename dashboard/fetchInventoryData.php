<?php
// Database connection parameters
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

// Query to get the total stock
$query = "SELECT SUM(InStock) AS TotalStock FROM `inventory`";

$result = $conn->query($query);

if (!$result) {
    die("Error in query: " . $conn->error);
}

$data = $result->fetch_assoc();

$totalStock = $data['TotalStock'] ?? 0;

// Format the total stock
$formattedTotalStock = number_format($totalStock);

// Return the result as JSON
header('Content-Type: application/json');
echo json_encode([
    'totalStock' => $formattedTotalStock
]);

// Close connection
$conn->close();
?>