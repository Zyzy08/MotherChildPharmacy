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

// Function to log actions
function logAction($conn, $userId, $action, $description, $status)
{
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $logSql = "INSERT INTO audittrail (AccountID, action, description, ip_address, status) VALUES (?, ?, ?, ?, ?)";
    $logStmt = $conn->prepare($logSql);
    $logStmt->bind_param("ssssi", $userId, $action, $description, $ipAddress, $status);
    $logStmt->execute();
    $logStmt->close();
}
session_start(); // Start the session to access user data
$sessionAccountID = $_SESSION['AccountID'] ?? null;

// Check if 'InvoiceID' is set in the query string
if (isset($_GET['InvoiceID'])) {
    $InvoiceID = $conn->real_escape_string($_GET['InvoiceID']);

    // Updated SQL query with JOIN
    $sql = "
        SELECT 
            s.InvoiceID, 
            DATE_FORMAT(s.SaleDate, '%m/%d/%y (%l:%i %p)') AS SalesDate, 
            s.TotalItems, 
            s.Subtotal,
            s.NetAmount, 
            s.PaymentMethod,
            s.Tax,
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
            s.InvoiceID = '$InvoiceID'
    ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Parse SalesDetails JSON
        $salesDetails = json_decode($data['SalesDetails'], true);
        $listItems = [];

        // Loop through sales details to get item names
        foreach ($salesDetails as $detail) {
            $itemID = $detail['itemID'];
            $qty = $detail['qty'];

            // Fetch the item details from the inventory
            $sqlItem = "SELECT * FROM inventory WHERE ItemID = '$itemID'";
            $itemResult = $conn->query($sqlItem);
            if ($itemResult->num_rows > 0) {
                $itemData = $itemResult->fetch_assoc();
                $genericName = $itemData['GenericName'];
                $brandName = $itemData['BrandName'];
                $pricePerUnit = $itemData['PricePerUnit'];
                $mass = $itemData['Mass'];
                $unitofmeasure = $itemData['UnitOfMeasure'];

                // Format the item string with quantity, description, and price
                $listItems[] = [
                    'qty' => $qty,
                    'description' => $brandName ? $brandName . " " . $mass . $unitofmeasure : $genericName . " " . $mass . $unitofmeasure,
                    'price' => $pricePerUnit                    
                ];
            }
        }

        // Set the listItems in the response
        $data['listItems'] = $listItems;  // Use 'listItems' for clarity in JavaScript

    } else {
        $data = null;
    }

    $updatedetails = "(Invoice ID: IN-0" . $InvoiceID . ")";
    //Log if Success
    $description = "User viewed a transaction's details $updatedetails.";
    //logAction($conn, $sessionAccountID, 'View Invoice', $description, 1);

    echo json_encode($data);
} else {
    //Log if Fail
    $description = "User failed to view a transaction's details. Error: " . $stmt->error;
    logAction($conn, $sessionAccountID, 'View Invoice', $description, 0);
    echo json_encode(null);
}

$conn->close();
?>