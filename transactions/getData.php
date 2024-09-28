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
            s.SalesDetails
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
            $sqlItem = "SELECT GenericName, BrandName, PricePerUnit FROM inventory WHERE ItemID = '$itemID'";
            $itemResult = $conn->query($sqlItem);
            if ($itemResult->num_rows > 0) {
                $itemData = $itemResult->fetch_assoc();
                $genericName = $itemData['GenericName'];
                $brandName = $itemData['BrandName'];
                $pricePerUnit = $itemData['PricePerUnit'];
                
                // Format the item string
                $listItems[] = "$qty  @  $pricePerUnit\t| $genericName $brandName";
            }
        }
    
        // Join all items into a single string with new lines
        $data['listQTY'] = implode("\n", $listItems);
    } else {
        $data = null;
    }
    
    echo json_encode($data);
} else {
    echo json_encode(null);
}

$conn->close();
?>
