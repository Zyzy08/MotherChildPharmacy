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

$updatedetails = "(SupplierID: " . $supplierID . ")";

// Execute the query
if ($stmt->execute()) {
    //Log if Success
    $description = "User unarchived a supplier. $updatedetails.";
    logAction($conn, $sessionAccountID, 'Unarchive Supplier', $description, 1);
    echo json_encode(['success' => true, 'message' => 'Supplier unarchived successfully.']);
} else {
    //Log if Fail
    $description = "User failed to unarchive a supplier. $updatedetails.";
    logAction($conn, $sessionAccountID, 'Unarchive Supplier', $description, 0);
    echo json_encode(['success' => false, 'message' => 'Error unarchiving supplier: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>