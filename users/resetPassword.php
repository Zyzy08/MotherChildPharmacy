<?php
session_start(); // Start the session to use session variables
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

// Get the accountName from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$accountName = $data['accountName'] ?? '';

if (empty($accountName)) {
    echo json_encode(['success' => false, 'message' => 'Account name is required.']);
    exit;
}

// Prepare and bind statement to fetch user details
$stmt = $conn->prepare("SELECT employeeLName, AccountID FROM users WHERE accountName = ?");
$stmt->bind_param("s", $accountName);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($employeeLName, $AccountID);

if ($stmt->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
    $stmt->close();
    $conn->close();
    exit;
}

// Fetch the user details
$stmt->fetch();
$stmt->close();

// Generate the new password
$formattedAccountID = str_pad($AccountID, 3, '0', STR_PAD_LEFT); // Format AccountID to three places
$newPassword = strtolower($employeeLName) . "-e" . $formattedAccountID;

// Prepare and bind statement to update the user's password
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE accountName = ?");
$stmt->bind_param("ss", $newPassword, $accountName);

// Execute the query
if ($stmt->execute()) {
    // Log the password reset action using session AccountID
    $sessionAccountID = $_SESSION['AccountID'] ?? null; // Get the AccountID from the session
    logAction($conn, $sessionAccountID, 'Password Reset', 'Password reset successfully for account: ' . $accountName);

    echo json_encode(['success' => true, 'message' => 'Password reset successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error resetting password: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Function to log actions
function logAction($conn, $userId, $action, $description)
{
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
?>