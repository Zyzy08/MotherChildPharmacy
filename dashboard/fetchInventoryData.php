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

// Get the filter parameter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'instock';

// Define the low stock threshold
$lowStockThreshold = 49; // Adjust this value based on your needs

// Prepare the query based on the filter
switch($filter) {
    case 'instock':
        $query = "SELECT COUNT(*) as count FROM `inventory` WHERE InStock > $lowStockThreshold";
        break;
    case 'lowstock':
        $query = "SELECT COUNT(*) as count FROM `inventory` WHERE InStock > 0 AND InStock <= $lowStockThreshold";
        break;
    case 'outofstock':
        $query = "SELECT COUNT(*) as count FROM `inventory` WHERE InStock = 0";
        break;
    default:
        $query = "SELECT COUNT(*) as count FROM `inventory` WHERE InStock > 0";
}

$result = $conn->query($query);

if (!$result) {
    die("Error in query: " . $conn->error);
}

$data = $result->fetch_assoc();

// Format the count
$count = number_format($data['count']);

// Return the result as JSON
header('Content-Type: application/json');
echo json_encode([
    'count' => $count,
    'filter' => $filter
]);

// Close connection
$conn->close();
?>