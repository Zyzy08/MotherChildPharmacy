<?php
// Database connection parameters
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

// Function to format the unit of measure
function formatUnitOfMeasure($unit) {
    $unitMap = [
        'kilograms' => 'kg',
        'milligrams' => 'mg',
        'grams' => 'g',
        'liters' => 'L',
        'milliliters' => 'mL',
        'pieces' => 's'
    ];
    return isset($unitMap[strtolower($unit)]) ? $unitMap[strtolower($unit)] : $unit;
}

// SQL query to fetch sales with items and quantities separately
$sql = "SELECT 
    s.InvoiceID,
    s.SaleDate,
    JSON_UNQUOTE(s.SalesDetails) AS SalesDetails,
    s.NetAmount
FROM 
    sales s
WHERE 
    DATE(s.SaleDate) = CURDATE()
ORDER BY 
    s.SaleDate DESC";

$result = $conn->query($sql);

if (!$result) {
    die(json_encode(array(
        "error" => "Query failed",
        "mysql_error" => $conn->error
    )));
}

// Create an array to store the fetched sales data
$salesData = array();
while ($row = $result->fetch_assoc()) {
    $items = [];
    $quantities = [];

    // Decode the JSON SalesDetails
    $salesDetails = json_decode($row['SalesDetails'], true);

    foreach ($salesDetails as $detail) {
        // Assuming each detail has 'itemID' and 'qty'
        $itemID = $detail['itemID'];
        $quantity = $detail['qty'];

        // Fetch item details from inventory
        $itemSql = "SELECT BrandName, GenericName, Mass, UnitOfMeasure FROM inventory WHERE ItemID = '$itemID'";
        $itemResult = $conn->query($itemSql);

        if ($itemResult && $itemResult->num_rows > 0) {
            $itemRow = $itemResult->fetch_assoc();
            // Format item name and unit
            $formattedItem = sprintf("%s %s %s%s", 
                $itemRow['BrandName'], 
                $itemRow['GenericName'], 
                $itemRow['Mass'], 
                formatUnitOfMeasure($itemRow['UnitOfMeasure'])
            );

            $items[] = $formattedItem;
            $quantities[] = $quantity;
        }
    }

    // Join items and quantities with line breaks for HTML display
    $salesData[] = array(
        'InvoiceID' => $row['InvoiceID'],
        'SaleDate' => $row['SaleDate'],
        'Items' => implode('<br /><br />', $items),
        'Quantities' => implode('<br /><br />', $quantities),
        'NetAmount' => floatval($row['NetAmount'])
    );
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($salesData);

// Close connection
$conn->close();
?>