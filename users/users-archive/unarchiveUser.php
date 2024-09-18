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

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'User archived successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error archiving user: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
