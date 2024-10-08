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
$itemID = $data['itemID'] ?? '';

if (empty($itemID)) {
    echo json_encode(['success' => false, 'message' => 'Item ID is required.']);
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE inventory SET Status = 'Active' WHERE ItemID = ?");
$stmt->bind_param("s", $itemID); // Assuming ItemID is a string; change "s" to "i" if it's an integer

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product unarchived successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error unarchiving product: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
