<?php
// Set response header to return JSON
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

// Get the supplierID from the POST request
$data = json_decode(file_get_contents('php://input'), true);

// Check if data is retrieved correctly
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

$supplierID = $data['SupplierID'] ?? ''; // Use SupplierID with the correct case

if (empty($supplierID)) {
    echo json_encode(['success' => false, 'message' => 'Supplier ID is required.']);
    exit;
}

// Prepare and bind the statement
$stmt = $conn->prepare("UPDATE suppliers SET status = 'Archived' WHERE SupplierID = ?");
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Prepare statement failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $supplierID);

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Supplier archived successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error archiving supplier: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
