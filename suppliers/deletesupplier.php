<?php
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

// Get the supplier ID from the query string (DELETE request)
$SupplierID = $_GET['id'];

// Prepare the SQL statement to delete the supplier by ID
$stmt = $conn->prepare("DELETE FROM suppliers WHERE SupplierID = ?");
$stmt->bind_param("s", $SupplierID);

// Execute the statement
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Supplier deleted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Supplier not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting supplier: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
