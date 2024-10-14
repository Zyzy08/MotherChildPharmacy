<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// Check if the user is logged in
if (isset($_SESSION['AccountID'])) {
    $accountID = $_SESSION['AccountID'];

    // Update connected status to 0
    $updateSql = "UPDATE users SET connected = '0' WHERE AccountID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $accountID);

    // Log the successful logout action
    logAction($conn, $_SESSION['AccountID'], 'Logout', 'User logged out successfully.');
    
    if ($updateStmt->execute()) {
        // Clear the session
        session_unset();
        session_destroy();

        // Respond with success
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'User signed out successfully'
        ]);
    } else {
        // Respond with error if update failed
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update connected status'
        ]);
    }

    $updateStmt->close();
} else {
    // User not logged in
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'No user is logged in'
    ]);
}

$conn->close();
?>
