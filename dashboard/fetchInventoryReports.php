<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$report = $_GET['report'];

switch ($report) {
    case 'in-stock': 
        $sql = "SELECT 
                ItemID, 
                GenericName, 
                BrandName, 
                InStock, 
                COALESCE(PricePerUnit, 0) AS PricePerUnit,
                ROUND(InStock * COALESCE(PricePerUnit, 0), 2) AS TotalInventoryValue,
                CASE 
                    WHEN InStock <= ReorderLevel * 0.2 THEN 'Critical'
                    WHEN InStock <= ReorderLevel * 0.5 THEN 'Low'
                    ELSE 'Good'
                END AS InventoryStatus
            FROM inventory 
            WHERE InStock > 0 
            AND Status = 'Active'";
        break;
    case 'low-stock':
        $sql = "SELECT 
                ItemID, 
                BrandName, 
                GenericName, 
                InStock, 
                ReorderLevel, 
                ROUND(InStock * COALESCE(PricePerUnit, 0), 2) AS TotalInventoryValue,
                CASE 
                    WHEN InStock <= ReorderLevel * 0.2 THEN 'Critical'
                    WHEN InStock <= ReorderLevel * 0.5 THEN 'Low'
                    ELSE 'Good'
                END AS InventoryStatus
                FROM inventory 
                WHERE InStock < ReorderLevel 
                AND Status = 'Active'";
        break;
    case 'overstock':
        $sql = "SELECT 
                ItemID, 
                BrandName, 
                GenericName, 
                InStock, 
                ReorderLevel, 
                (InStock - ReorderLevel) AS ExcessStock,
                ROUND(InStock * COALESCE(PricePerUnit, 0), 2) AS TotalInventoryValue,
                CASE 
                    WHEN InStock > ReorderLevel * 2 THEN 'Overstocked'
                    WHEN InStock > ReorderLevel THEN 'Above Normal'
                    ELSE 'Normal'
                END AS InventoryStatus
                FROM inventory 
                WHERE InStock > ReorderLevel 
                AND Status = 'Active'";
        break;
    case 'out-of-stock':
        $sql = "SELECT 
                ItemID, 
                BrandName, 
                GenericName,
                COALESCE(PricePerUnit, 0) AS LastKnownPrice
                FROM inventory 
                WHERE InStock = 0 
                AND Status = 'Active'";
        break;
    case 'near-expiry':
        $sql = "SELECT 
                inv.ItemID, 
                inv.BrandName, 
                inv.GenericName, 
                del.ExpiryDate, 
                del.LotNumber,
                COALESCE(inv.PricePerUnit, 0) AS PricePerUnit,
                DATEDIFF(del.ExpiryDate, CURDATE()) AS DaysToExpiry
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