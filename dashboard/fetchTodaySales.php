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

// Get the period from the request
$period = isset($_GET['period']) ? $_GET['period'] : 'today';

// Define the SQL query based on the period
switch ($period) {
    case 'today':
        $sql = "SELECT 
            s.InvoiceID,
            s.SaleDate,
            s.Status AS TransactionType,
            JSON_UNQUOTE(s.SalesDetails) AS SalesDetails,
            s.NetAmount
        FROM 
            sales s
        WHERE 
            DATE(s.SaleDate) = CURDATE() AND s.Status IN ('Sales', 'Return/Exchange', 'ReturnedForExchange')
        ORDER BY 
            s.SaleDate DESC";
        break;
    case 'month':
        $sql = "SELECT 
            s.InvoiceID,
            s.SaleDate,
            s.Status AS TransactionType,
            JSON_UNQUOTE(s.SalesDetails) AS SalesDetails,
            s.NetAmount
        FROM 
            sales s
        WHERE 
            YEAR(s.SaleDate) = YEAR(CURDATE()) AND MONTH(s.SaleDate) = MONTH(CURDATE()) AND s.Status IN ('Sales', 'Return/Exchange', 'ReturnedForExchange')
        ORDER BY 
            s.SaleDate DESC";
        break;
    case 'year':
        $sql = "SELECT 
            s.InvoiceID,
            s.SaleDate,
            s.Status AS TransactionType,
            JSON_UNQUOTE(s.SalesDetails) AS SalesDetails,
            s.NetAmount
        FROM 
            sales s
        WHERE 
            YEAR(s.SaleDate) = YEAR(CURDATE()) AND s.Status IN ('Sales', 'Return/Exchange', 'ReturnedForExchange')
        ORDER BY 
            s.SaleDate DESC";
        break;
    default:
        die(json_encode(array(
            "error" => "Invalid period specified"
        )));
}

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
        'TransactionType' => $row['TransactionType'],
        'Items' => implode('<br /><br />', $items),
        'Quantities' => implode('<br /><br /><br />', $quantities),
        'NetAmount' => floatval($row['NetAmount'])
    );
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($salesData);

// Close connection
$conn->close();
?>