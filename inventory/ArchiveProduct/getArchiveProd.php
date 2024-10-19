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
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// SQL query to fetch products with status 'Archived'
$sql = "SELECT ItemID, GenericName, BrandName, ItemType, Mass, UnitOfMeasure, InStock, Ordered, ReorderLevel, PricePerUnit, SupplierID, Notes, ProductIcon, ProductCode, Discount 
        FROM inventory 
        WHERE Status = 'Archived'";
$result = $conn->query($sql);

// Check if query execution was successful
if (!$result) {
    die(json_encode(['error' => 'Query failed: ' . $conn->error]));
}

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format the ProductIcon path
        $row['ProductIcon'] = '../products-icon/' . $row['ProductIcon'];
        $data[] = $row;
    }
}

// Close the database connection
$conn->close();

// Output the data in JSON format
if (!empty($data)) {
    echo json_encode($data);
} else {
    // Output an empty JSON array instead of just a 204 status code
    echo json_encode([]);
    http_response_code(200);
}
