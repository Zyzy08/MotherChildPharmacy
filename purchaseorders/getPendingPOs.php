<?php
header('Content-Type: application/json');

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

// Modify the SQL query to include a JOIN with the suppliers table
$sql = "SELECT 
    po.PurchaseOrderID, 
    DATE_FORMAT(po.OrderDate, '%m/%d/%Y') AS OrderDate, 
    po.TotalItems, 
    po.Status, 
    s.SupplierName
    FROM 
    purchaseorders po
    JOIN 
    suppliers s ON po.SupplierID = s.SupplierID WHERE 
    po.Status IN ('Pending', 'Partially Received');";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

echo json_encode($data);
?>