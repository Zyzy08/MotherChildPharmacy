<?php
// Database connection
$host = 'localhost';
$db = 'motherchildpharmacy';
$user = 'root';
$password = '';
$conn = new mysqli($host, $user, $password, $db);

// Fetch overstock data
$sql = "
    SELECT 
    ItemID,
    BrandName,
    GenericName,
    InStock,
    ReorderLevel,
    (InStock - ReorderLevel) AS ExcessStock
FROM inventory
WHERE InStock > ReorderLevel
AND Status = 'Active'
";

$result = $conn->query($sql);

$overstockItems = [];
while ($row = $result->fetch_assoc()) {
    $overstockItems[] = $row;
}

echo json_encode($overstockItems);
?>
