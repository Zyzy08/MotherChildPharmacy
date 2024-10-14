<?php
header('Content-Type: application/json');

// Function to log actions
function logAction($conn, $userId, $action, $description) {
    // Prepare the SQL statement
    $sql2 = "INSERT INTO audittrail (AccountID, action, description, ip_address) VALUES (?, ?, ?, ?)";
    
    // Create a prepared statement
    $stmt2 = $conn->prepare($sql2);
    
    // Check if the statement was prepared correctly
    if ($stmt2 === false) {
        die('Error preparing the statement: ' . $conn->error);
    }
    
    // Bind the parameters
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $stmt2->bind_param("isss", $userId, $action, $description, $ipAddress);
    
    // Execute the statement
    if (!$stmt2->execute()) {
        die('Error executing the statement: ' . $stmt2->error);
    }

    // Close the statement
    $stmt2->close();
}

// Start the session to access session variables
session_start();

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

// Get the accountName from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$accountName = $data['accountName'] ?? '';

if (empty($accountName)) {
    echo json_encode(['success' => false, 'message' => 'Account name is required.']);
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE users SET status = 'Inactive' WHERE accountName = ?");
$stmt->bind_param("s", $accountName);

// Execute the query
if ($stmt->execute()) {
    // Log the action of archiving the user
    $sessionAccountID = $_SESSION['AccountID'] ?? null; // Get the AccountID from the session
    logAction($conn, $sessionAccountID, 'Archive User', 'Archived user account: ' . $accountName);

    echo json_encode(['success' => true, 'message' => 'User archived successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error archiving user: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
