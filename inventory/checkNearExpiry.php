<?php
// Database connection
$host = 'localhost';
$db = 'motherchildpharmacy';
$user = 'root';
$password = '';
$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch near expiry items
$sql = "SELECT inv.ItemID, inv.BrandName, inv.GenericName, del.ExpiryDate 
        FROM inventory inv
        JOIN delivery_items del ON inv.ItemID = del.ItemID
        WHERE del.ExpiryDate >= CURDATE() 
        ORDER BY del.ExpiryDate ASC";

$result = $conn->query($sql);

$items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($items);
?>