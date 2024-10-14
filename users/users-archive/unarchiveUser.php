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

// Function to log actions
function logAction($conn, $userId, $action, $description, $status)
{
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $logSql = "INSERT INTO audittrail (AccountID, action, description, ip_address, status) VALUES (?, ?, ?, ?, ?)";
    $logStmt = $conn->prepare($logSql);
    $logStmt->bind_param("ssssi", $userId, $action, $description, $ipAddress, $status);
    $logStmt->execute();
    $logStmt->close();
}

// Get the accountName from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$accountName = $data['accountName'] ?? '';

if (empty($accountName)) {
    echo json_encode(['success' => false, 'message' => 'Account name is required.']);
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE users SET status = 'Active' WHERE accountName = ?");
$stmt->bind_param("s", $accountName);

// Get the current user's AccountID from the session or other source
session_start();
$sessionAccountID = $_SESSION['AccountID'] ?? null;

// Execute the query
if ($stmt->execute()) {
    // Log success
    $description = "Unarchived user with account name: $accountName.";
    logAction($conn, $sessionAccountID, 'Unarchive User', $description, 1);

    echo json_encode(['success' => true, 'message' => 'User unarchived successfully.']);
} else {
    // Log failure
    $description = "Failed to unarchive user with account name: $accountName. Error: " . $stmt->error;
    logAction($conn, $sessionAccountID, 'Unarchive User', $description, 0);

    echo json_encode(['success' => false, 'message' => 'Error unarchiving user: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>