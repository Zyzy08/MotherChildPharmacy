<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost"; // Change if needed
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "motherchildpharmacy"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM suppliers");

// Execute the statement
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $suppliers = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['success' => true, 'suppliers' => $suppliers]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error retrieving suppliers: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
