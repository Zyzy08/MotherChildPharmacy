<?php
header('Content-Type: application/json');

// Database configuration
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

// SQL query to fetch suppliers with status 'Archived'
$sql = "SELECT SupplierID, SupplierName, AgentName, Phone, Email, Notes FROM suppliers WHERE status = 'Archived'";
$result = $conn->query($sql);

// Check if query execution was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close the database connection
$conn->close();

// Output the data in JSON format
if (!empty($data)) {
    echo json_encode($data);
} else {
    http_response_code(204); // No Content
}
?>
