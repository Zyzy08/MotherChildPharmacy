<?php
ini_set('display_errors', 0); // Turn off error display
error_reporting(E_ALL); // Report all errors
header('Content-Type: application/json'); // Ensure JSON content type is set

// Check if itemId is provided
if (!isset($_POST['itemId'])) {
    echo json_encode(['success' => false, 'message' => 'ItemID is required.']);
    exit;
}

// Get itemId from POST request
$itemId = $_POST['itemId'];

// Validate itemId (you may want to add more validation)
if (empty($itemId)) {
    echo json_encode(['success' => false, 'message' => 'ItemID cannot be empty.']);
    exit;
}

// Database connection (ensure this is correct)
$conn = new mysqli('localhost', 'root', '', 'motherchildpharmacy');

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Prepare and execute deletion query
$stmt = $conn->prepare("DELETE FROM inventory WHERE ItemID = ?");
$stmt->bind_param('i', $itemId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting product: ' . $stmt->error]);
}

// Close connection
$stmt->close();
$conn->close();
?>
