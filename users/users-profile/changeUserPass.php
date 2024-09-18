<?php
session_start(); // Start the session to access user data
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

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['password'] ?? '';
    $newPassword = $_POST['newpassword'] ?? '';
    $renewPassword = $_POST['renewpassword'] ?? '';

    // Validate input
    if (empty($currentPassword) || empty($newPassword) || empty($renewPassword)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Check if new passwords match
    if ($newPassword !== $renewPassword) {
        echo json_encode(['success' => false, 'message' => 'New passwords do not match.']);
        exit;
    }

    // Check password complexity
    if (!preg_match('/^(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?])[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]{7,}$/', $newPassword)) {
        echo json_encode(['success' => false, 'message' => 'New password must be at least 7 characters long and contain at least one number and one symbol.']);
        exit;
    }

    // Get the logged-in user's account ID (assuming you store it in session)
    $accountID = $_SESSION['AccountID'];

    // Fetch the current password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE AccountID = ?");
    $stmt->bind_param("s", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
        exit;
    }

    $user = $result->fetch_assoc();
    
    // Verify current password
    if ($currentPassword !== $user['password']) {
        echo json_encode(['success' => false, 'message' => 'Incorrect current password.']);
        exit;
    }

    // Check if the new password is the same as the old password
    if ($newPassword === $user['password']) {
        echo json_encode(['success' => false, 'message' => 'New password must not be the same as the old password.']);
        exit;
    }

    // Update the password in the database without hashing
    $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE AccountID = ?");
    $updateStmt->bind_param("ss", $newPassword, $accountID);

    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Password changed successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error changing password: ' . $updateStmt->error]);
    }

    // Close statements and connection
    $updateStmt->close();
    $stmt->close();
}

$conn->close();
?>
