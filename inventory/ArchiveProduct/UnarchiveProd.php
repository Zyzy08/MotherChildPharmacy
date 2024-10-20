<?php

header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
}

// Get JSON input from the request
$data = json_decode(file_get_contents('php://input'), true);
$itemID = $data['itemID'] ?? null;

if ($itemID) {
    // Prepare and execute SQL query to unarchive the product
    $stmt = $conn->prepare("UPDATE inventory SET status = 'active' WHERE ItemID = ?");
    $stmt->bind_param('s', $itemID);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product unarchived successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to unarchive product']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'No item ID provided']);
}

$conn->close();
?>
