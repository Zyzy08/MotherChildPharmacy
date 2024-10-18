<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Get the itemID from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$itemID = $data['itemID'] ?? ''; // Changed from accountName to itemID

if (empty($itemID)) {
    echo json_encode(['success' => false, 'message' => 'Item ID is required.']); // Updated message
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE inventory SET status = 'Archived' WHERE ItemID = ?"); // Changed table and status
$stmt->bind_param("s", $itemID); // Changed from accountName to itemID

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product archived successfully.']); // Updated message
} else {
    echo json_encode(['success' => false, 'message' => 'Error archiving product: ' . $stmt->error]); // Updated message
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
