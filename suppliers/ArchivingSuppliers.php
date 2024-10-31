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

function logAction($conn, $userId, $action, $description, $status)
{
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $logSql = "INSERT INTO audittrail (AccountID, action, description, ip_address, status) VALUES (?, ?, ?, ?, ?)";
    $logStmt = $conn->prepare($logSql);
    $logStmt->bind_param("ssssi", $userId, $action, $description, $ipAddress, $status);
    $logStmt->execute();
    $logStmt->close();
}

// Get the current user's AccountID from the session or other source
session_start();
$sessionAccountID = $_SESSION['AccountID'] ?? null;

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

$updatedetails = "(SupplierID: " . $supplierID . ")";

// Execute the query
if ($stmt->execute()) {
    //Log if Success
    $description = "User archived a supplier. $updatedetails.";
    logAction($conn, $sessionAccountID, 'Archive Supplier', $description, 1);
    echo json_encode(['success' => true, 'message' => 'Supplier archived successfully.']);
} else {
    //Log if Fail
    $description = "User failed to archive a supplier. $updatedetails.";
    logAction($conn, $sessionAccountID, 'Archive Supplier', $description, 0);
    echo json_encode(['success' => false, 'message' => 'Error archiving supplier: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>