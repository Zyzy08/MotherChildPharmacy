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
$day = isset($_GET['day']) ? $_GET['day'] : null;
$month = isset($_GET['month']) ? $_GET['month'] : null;
$year = isset($_GET['year']) ? $_GET['year'] : null;

// Base SQL query
$baseSql = "SELECT 
    s.InvoiceID,
    s.SaleDate,
    s.Status AS TransactionType,
    JSON_UNQUOTE(s.SalesDetails) AS SalesDetails,
    s.Subtotal,
    s.Tax,
    s.Discount,
    s.NetAmount,
    s.PaymentMethod
FROM 
    sales s
WHERE 
    s.Status IN ('Sales', 'Return/Exchange', 'ReturnedForExchange')";

// Modify base query based on period and additional filters
switch ($period) {
    case 'today':
        $sql = $baseSql . " AND DATE(s.SaleDate) = CURDATE()";
        break;
    
    case 'week':
        $sql = $baseSql . " AND YEAR(s.SaleDate) = YEAR(CURDATE()) AND WEEK(s.SaleDate, 1) = WEEK(CURDATE(), 1)";
        if ($day) {
            $sql .= " AND DAYNAME(s.SaleDate) = '$day'";
        }
        break;
    
    case 'month':
        $sql = $baseSql . " AND YEAR(s.SaleDate) = YEAR(CURDATE())";
        if ($month) {
            $monthNum = date('m', strtotime($month));
            $sql .= " AND MONTH(s.SaleDate) = '$monthNum'";
        } else {
            $sql .= " AND MONTH(s.SaleDate) = MONTH(CURDATE())";
        }
        break;
    
    case 'year':
        $sql = $baseSql;
        if ($year) {
            $sql .= " AND YEAR(s.SaleDate) = '$year'";
        } else {
            $sql .= " AND YEAR(s.SaleDate) = YEAR(CURDATE())";
        }
        break;
    
    default:
        die(json_encode(array(
            "error" => "Invalid period specified"
        )));
}

// Add ordering
$sql .= " ORDER BY s.SaleDate DESC";

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

    // Calculate total items
    $totalItems = array_sum($quantities);

    // Join items and quantities with line breaks for HTML display
    $salesData[] = array(
        'InvoiceID' => $row['InvoiceID'],
        'SaleDate' => $row['SaleDate'],
        'TotalItems' => $totalItems,
        'Subtotal' => floatval($row['Subtotal']),
        'Tax' => floatval($row['Tax']),
        'Discount' => floatval($row['Discount']),
        'NetAmount' => floatval($row['NetAmount']),
        'PaymentMethod' => $row['PaymentMethod'],
        'Status' => $row['TransactionType']
    );
}

//working

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($salesData);

// Close connection
$conn->close();
?>