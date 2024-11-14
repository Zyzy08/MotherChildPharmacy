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

// Get the selected tab from the query string
$selectedTab = isset($_GET['tab']) ? $_GET['tab'] : '1'; // Default to tab 1

// Default SQL with WHERE Status = 'Sales'
// $sql = "SELECT InvoiceID, DATE_FORMAT(SaleDate, '%m/%d/%y (%l:%i %p)') AS SalesDate, TotalItems, NetAmount, PaymentMethod FROM sales WHERE Status = 'Sales'";
$sql = "
        SELECT 
            s.InvoiceID, 
            DATE_FORMAT(s.SaleDate, '%m/%d/%y (%l:%i %p)') AS SalesDate,
            s.SaleDate AS SalesDateTime, 
            s.TotalItems, 
            s.Subtotal,
            s.NetAmount, 
            s.PaymentMethod,
            s.Tax,
            s.vatable_sales,
            s.vat_exempt_sales,            
            s.Discount, 
            s.AmountPaid,
            s.AmountChange,
            s.Status,
            u.employeeName, 
            u.employeeLName,
            s.SalesDetails,
            s.RefundAmount
        FROM 
            sales s
        JOIN 
            users u ON s.AccountID = u.AccountID 
        WHERE 
            s.Status = 'Sales'
    ";

switch ($selectedTab) {
    case '2':
        $sql = "
        SELECT 
            s.InvoiceID, 
            DATE_FORMAT(s.SaleDate, '%m/%d/%y (%l:%i %p)') AS SalesDate,
            s.SaleDate AS SalesDateTime, 
            s.TotalItems, 
            s.Subtotal,
            s.NetAmount, 
            s.PaymentMethod,
            s.Tax,
            s.vatable_sales,
            s.vat_exempt_sales,
            s.Discount, 
            s.AmountPaid,
            s.AmountChange,
            s.Status,
            u.employeeName, 
            u.employeeLName,
            s.SalesDetails,
            s.RefundAmount
        FROM 
            sales s
        JOIN 
            users u ON s.AccountID = u.AccountID 
        WHERE 
            s.Status = 'Return/Exchange';
    ";
        break;
    case '3':
        $sql = "
        SELECT 
            s.InvoiceID, 
            DATE_FORMAT(s.SaleDate, '%m/%d/%y (%l:%i %p)') AS SalesDate,
            s.SaleDate AS SalesDateTime, 
            s.TotalItems, 
            s.Subtotal,
            s.NetAmount, 
            s.PaymentMethod,
            s.Tax,
            s.vatable_sales,
            s.vat_exempt_sales,
            s.Discount, 
            s.AmountPaid,
            s.AmountChange,
            s.Status,
            u.employeeName, 
            u.employeeLName,
            s.SalesDetails,
            s.RefundAmount
        FROM 
            sales s
        JOIN 
            users u ON s.AccountID = u.AccountID 
        WHERE 
            s.Status IN ('Returned', 'ReturnedForExchange')";
        break;
    // Default to tab 1 is already handled
}

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