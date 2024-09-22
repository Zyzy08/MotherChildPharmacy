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

// Get the supplier ID from the query strings
$SupplierID = $_GET['id'];

// Prepare the SQL statement to select the supplier by ID
$stmt = $conn->prepare("SELECT * FROM suppliers WHERE SupplierID = ?");
$stmt->bind_param("s", $SupplierID);

// Execute the statement
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $suppliers = $result->fetch_assoc();
        echo json_encode(['success' => true, 'supplier' => $suppliers]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Supplier not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error retrieving supplier: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
