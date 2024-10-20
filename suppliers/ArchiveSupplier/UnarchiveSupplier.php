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

// Get the SupplierID from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$supplierID = $data['itemID'] ?? null;

if (empty($supplierID)) {
    echo json_encode(['success' => false, 'message' => 'Supplier ID is required.']);
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE suppliers SET status = 'Active' WHERE SupplierID = ?");
$stmt->bind_param("s", $supplierID);

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Supplier unarchived successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error unarchiving supplier: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
