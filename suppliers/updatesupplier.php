<?php
header('Content-Type: application/json');

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
$stmt = $conn->prepare("UPDATE suppliers SET SupplierName = ?, AgentName = ?, Phone = ?, Email = ?, Status = ? WHERE SupplierID = ?");
$stmt->bind_param("ssssss", $SupplierName, $AgentName, $Phone, $Email, $Status, $SupplierID);

// Get data from POST request
$SupplierID = $_POST['id'];
$SupplierName = $_POST['supplier-name-edit'];
$AgentName = $_POST['agent-name-edit'];
$Phone = $_POST['phone-edit'];
$Email = $_POST['email-edit'];
$Status = $_POST['status'] ?? 'active'; // Default to 'active' if not provided

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Supplier updated successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating supplier: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
