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

// Check if the user is logged in
if (isset($_SESSION['AccountID'])) {
    $accountID = $_SESSION['AccountID'];

    // Update connected status to 0
    $updateSql = "UPDATE users SET connected = '0' WHERE AccountID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $accountID);
    
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
