<?php

header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create connection
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
    die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
}

// Get JSON input from the request
$data = json_decode(file_get_contents('php://input'), true);
$itemID = $data['itemID'] ?? null;

if ($itemID) {
    // Prepare and execute SQL query to unarchive the product
    $stmt = $conn->prepare("UPDATE inventory SET status = 'active' WHERE ItemID = ?");
    $stmt->bind_param('s', $itemID);

    $updatedetails = "(ItemID: " . $itemID . ")";

    if ($stmt->execute()) {
        //Log if Success
        $description = "User unarchived a product. $updatedetails.";
        logAction($conn, $sessionAccountID, 'Unarchive Product', $description, 1);
        echo json_encode(['success' => true, 'message' => 'Product unarchived successfully']);
    } else {
        //Log if Fail
        $description = "User failed to unarchive a product. $updatedetails.";
        logAction($conn, $sessionAccountID, 'Unarchive Product', $description, 0);
        echo json_encode(['success' => false, 'message' => 'Failed to unarchive product']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'No item ID provided']);
}

$conn->close();
?>