<?php
session_start(); // Start the session

// Check if the user is logged in by checking for AccountID in the session
if (!isset($_SESSION['AccountID'])) {
    // Return error response if not logged in
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Get the AccountID from the session
$accountID = $_SESSION['AccountID'];

// Return the AccountID in JSON format
echo json_encode(['accountID' => $accountID]);
?>
