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

// Get the period from the GET parameter
$period = $_GET['period'] ?? 'today';

// Define the queries based on the period
// Define the queries based on the period
switch ($period) {
    case 'today':
        $currentQuery = "SELECT COUNT(DISTINCT InvoiceID) as total 
                         FROM sales 
                         WHERE DATE(SaleDate) = CURDATE() 
                         AND Status IN ('Sales', 'Return/Exchange')";

        $previousQuery = "SELECT COUNT(DISTINCT InvoiceID) as total 
                          FROM sales 
                          WHERE DATE(SaleDate) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) 
                          AND Status IN ('Sales', 'Return/Exchange')";
        break;

    case 'month':
        $currentQuery = "SELECT COUNT(DISTINCT InvoiceID) as total 
                         FROM sales 
                         WHERE YEAR(SaleDate) = YEAR(CURDATE()) 
                         AND MONTH(SaleDate) = MONTH(CURDATE()) 
                         AND Status IN ('Sales', 'Return/Exchange')";

        $previousQuery = "SELECT COUNT(DISTINCT InvoiceID) as total 
                          FROM sales 
                          WHERE YEAR(SaleDate) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                          AND MONTH(SaleDate) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                          AND Status IN ('Sales', 'Return/Exchange')";
        break;

    case 'year':
        $currentQuery = "SELECT COUNT(DISTINCT InvoiceID) as total 
                         FROM sales 
                         WHERE YEAR(SaleDate) = YEAR(CURDATE()) 
                         AND Status IN ('Sales', 'Return/Exchange')";

        $previousQuery = "SELECT COUNT(DISTINCT InvoiceID) as total 
                          FROM sales 
                          WHERE YEAR(SaleDate) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) 
                          AND Status IN ('Sales', 'Return/Exchange')";
        break;

    default:
        die("Invalid period specified");
}


$currentResult = $conn->query($currentQuery);
$previousResult = $conn->query($previousQuery);

if (!$currentResult || !$previousResult) {
    die("Error in query: " . $conn->error);
}

$currentData = $currentResult->fetch_assoc();
$previousData = $previousResult->fetch_assoc();

$currentTotal = $currentData['total'] ?? 0;
$previousTotal = $previousData['total'] ?? 0;

// Calculate percentage change
$percentageChange = 0;
if ($previousTotal > 0) {
    $percentageChange = (($currentTotal - $previousTotal) / $previousTotal) * 100;
}

// Format the totals and percentage
$formattedPercentage = number_format(abs($percentageChange), 1);

// Determine if it's an increase or decrease
$changeType = $percentageChange >= 0 ? 'increase' : 'decrease';

// Return the result as JSON
header('Content-Type: application/json');
echo json_encode([
    'total' => $currentTotal,
    'percentage' => $formattedPercentage,
    'changeType' => $changeType
]);

// Close connection
$conn->close();
?>