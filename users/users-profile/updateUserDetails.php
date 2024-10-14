<?php
session_start();
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountID = $_SESSION['AccountID'];
    $fullName = $_POST['fullName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $picture = $_FILES['profileImage'] ?? null;

    // Validate input
    if (empty($fullName) || empty($lastName)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Create accountName based on the first letter of the first name and the entire last name
    $dynamicPrefix = 'E' . str_pad($accountID, 3, '0', STR_PAD_LEFT);
    $accountName = $dynamicPrefix . '_' . strtolower(substr($fullName, 0, 1) . $lastName);

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE users SET employeeName = ?, employeeLName = ?, accountName = ?" . ($picture && $picture['error'] == 0 ? ", picture = ?" : "") . " WHERE AccountID = ?");

    // Bind parameters
    if ($picture && $picture['error'] == 0) {
        $targetDir = "../../users/uploads/";
        $picturePath = basename($picture['name']);
        move_uploaded_file($picture['tmp_name'], $targetDir . $picturePath);
        $stmt->bind_param("sssss", $fullName, $lastName, $accountName, $picturePath, $accountID);
        $updatedetails = "(Picture: $picturePath, Name: $fullName $lastName)";
    } else {
        $stmt->bind_param("ssss", $fullName, $lastName, $accountName, $accountID);
        $updatedetails = "(Name: $fullName $lastName)";
    }
    $sessionAccountID = $_SESSION['AccountID'] ?? null;
    // Execute the statement
    if ($stmt->execute()) {
        $description = "User successfully updated their own profile $updatedetails.";
        logAction($conn, $sessionAccountID, 'Profile Update', $description, 1);
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
    } else {
        // Log failure
        $description = "User failed to update their own profile $updatedetails. Error: " . $stmt->error;
        logAction($conn, $sessionAccountID, 'Profile Update', $description, 0);
        echo json_encode(['success' => false, 'message' => 'Error updating profile: ' . $stmt->error]);
    }

    $stmt->close();
}
$conn->close();
?>