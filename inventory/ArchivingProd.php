<?php
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
$updatedetails = "(ItemID: " . $itemID . ")";

// Execute the query
if ($stmt->execute()) {
    //Log if Success
    $description = "User archived a product. $updatedetails.";
    logAction($conn, $sessionAccountID, 'Archive Product', $description, 1);
    echo json_encode(['success' => true, 'message' => 'Product archived successfully.']); // Updated message
} else {
    //Log if Fail
    $description = "User failed to archive a product. $updatedetails.";
    logAction($conn, $sessionAccountID, 'Archive Product', $description, 0);
    echo json_encode(['success' => false, 'message' => 'Error archiving product: ' . $stmt->error]); // Updated message
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>