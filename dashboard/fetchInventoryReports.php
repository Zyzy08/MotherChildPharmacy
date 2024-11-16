<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine which report to fetch
$report = $_GET['report'];

switch ($report) {
    case 'in-stock': 
        $sql = "SELECT ItemID, BrandName, GenericName, InStock
                FROM inventory 
                WHERE InStock > 0 
                AND Status = 'Active'";
        break;
    case 'low-stock':
        $sql = "SELECT ItemID, BrandName, GenericName, InStock, ReorderLevel 
                FROM inventory 
                WHERE InStock < ReorderLevel 
                AND Status = 'Active'";
        break;
    case 'overstock':
        $sql = "SELECT ItemID, BrandName, GenericName, InStock, ReorderLevel, 
                (InStock - ReorderLevel) AS ExcessStock
                FROM inventory 
                WHERE InStock > ReorderLevel 
                AND Status = 'Active'";
        break;
    case 'out-of-stock':
        $sql = "SELECT ItemID, BrandName, GenericName 
                FROM inventory 
                WHERE InStock = 0 
                AND Status = 'Active'";
        break;
    case 'near-expiry':
        $sql = "SELECT inv.ItemID, inv.BrandName, inv.GenericName, del.ExpiryDate, del.LotNumber
                FROM inventory inv
                JOIN delivery_items del ON inv.ItemID = del.ItemID
                WHERE del.ExpiryDate >= CURDATE() 
                AND del.ExpiryDate <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH)
                ORDER BY del.ExpiryDate ASC";
        break;
    default:
        die("Invalid report type.");
}

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
