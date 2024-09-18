<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0); // Turn off display errors in production

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Retrieve and validate search query
$searchQuery = $_POST['searchQuery'] ?? '';

if (empty($searchQuery)) {
    echo json_encode(['success' => false, 'message' => 'Search query cannot be empty.']);
    exit;
}

// Prepare the SQL statement to search products based on item name, brand, or type
$sql = "SELECT ItemName, GenericName, BrandName, ItemType, Mass, UnitOfMeasure, PricePerUnit, Notes, Status 
        FROM inventory 
        WHERE ItemName LIKE ? OR BrandName LIKE ? OR ItemType LIKE ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL statement.']);
    exit;
}

// Bind parameters for searching in ItemName, BrandName, or ItemType
$likeQuery = '%' . $searchQuery . '%';
$stmt->bind_param('sss', $likeQuery, $likeQuery, $likeQuery);

// Execute the statement
if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Query execution failed: ' . $stmt->error]);
    exit;
}

// Fetch results
$result = $stmt->get_result();
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['success' => true, 'results' => $data]);
} else {
    echo json_encode(['success' => true, 'results' => [], 'message' => 'No products found matching the search query.']);
}

// Close connections
$stmt->close();
$conn->close();
?>
