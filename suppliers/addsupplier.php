<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost"; // Change if needed
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "motherchildpharmacy"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO suppliers (SupplierID, SupplierName, AgentName, Phone, Email, Status) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssss", $SupplierID, $SupplierName, $AgentName, $Phone, $Email, $Status);

// Generate a unique supplier ID
$SupplierID = uniqid('S');

// Get data from POST request
$SupplierName = $_POST['supplier-name'];
$AgentName = $_POST['agent-name'];
$Phone = $_POST['phone'];
$Email = $_POST['email'];
$Status = 'active'; // Set the default status to 'active'

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Supplier added successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error adding supplier: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
