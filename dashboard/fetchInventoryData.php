<?php
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

// Get the status from the request
$status = $_GET['status'] ?? 'in-stock';

// Query based on status
$query = match($status) {
    'in-stock' => "SELECT COUNT(*) as count FROM inventory WHERE InStock >= 50",
    'low-stock' => "SELECT COUNT(*) as count FROM inventory WHERE InStock BETWEEN 1 AND 49",
    'out-of-stock' => "SELECT COUNT(*) as count FROM inventory WHERE InStock = 0",
    default => "SELECT COUNT(*) as count FROM inventory WHERE InStock >= 50"
};

$result = $conn->query($query);

if (!$result) {
    die("Error in query: " . $conn->error);
}

$data = $result->fetch_assoc();

// Format the count
$response = [
    'count' => number_format($data['count'] ?? 0),
    'status' => $status
];

// Return the result as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close connection
$conn->close();
?>