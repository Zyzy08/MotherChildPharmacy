<?php
ini_set('display_errors', 1); // Temporarily turn on error display for debugging
error_reporting(E_ALL); // Report all errors
header('Content-Type: application/json'); // Ensure JSON content type is set

// Check if itemID is provided
if (!isset($_GET['itemID'])) {
    echo json_encode(['success' => false, 'message' => 'ItemID is required.']);
    exit;
}

// Get itemID from GET request
$itemId = $_GET['itemID'];

// Validate itemID
if (empty($itemId)) {
    echo json_encode(['success' => false, 'message' => 'ItemID cannot be empty.']);
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'motherchildpharmacy');

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Prepare and execute deletion query
$stmt = $conn->prepare("DELETE FROM inventory WHERE ItemID = ?");
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Prepare statement failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param('i', $itemId);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Product deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No product found with the given ItemID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting product: ' . $stmt->error]);
}

// Close connection
$stmt->close();
$conn->close();
?>
