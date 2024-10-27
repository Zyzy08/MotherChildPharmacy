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

// Modify the SQL query
$sql = "
    SELECT 
    d.DeliveryID, 
    d.PurchaseOrderID, 
    DATE_FORMAT(d.DeliveryDate, '%m/%d/%Y') AS DeliveryDate, 
    s.SupplierName, 
    u.AccountName AS ReceivedBy,
    u.employeeName, 
    u.employeeLName, 
    SUM(di.QuantityDelivered) AS TotalItemsDelivered, 
    SUM(di.Bonus) AS TotalItemsBonus,
    GROUP_CONCAT(DISTINCT di.LotNumber) AS LotNumbers, 
    d.DeliveryStatus
FROM 
    deliveries d
JOIN 
    purchaseorders po ON d.PurchaseOrderID = po.PurchaseOrderID
JOIN 
    suppliers s ON po.SupplierID = s.SupplierID
JOIN 
    users u ON d.ReceivedBy = u.AccountID
JOIN 
    delivery_items di ON d.DeliveryID = di.DeliveryID
GROUP BY 
    d.DeliveryID;

";

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