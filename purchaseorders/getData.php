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
        po.PurchaseOrderID, 
        DATE_FORMAT(po.OrderDate, '%m/%d/%y (%l:%i %p)') AS OrderDate,
        po.OrderDate AS OrderDateOrig, 
        po.TotalItems, 
        po.Status, 
        po.NetAmount, 
        u.employeeName, 
        u.employeeLName,
        s.SupplierName,
        po.OrderDetails
    FROM 
        purchaseorders po
    JOIN 
        users u ON po.AccountID = u.AccountID
    JOIN 
        suppliers s ON po.SupplierID = s.SupplierID
    WHERE 
        po.PurchaseOrderID = '$InvoiceID';
    ";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        // Parse OrderDetails JSON
        $salesDetails = json_decode($data['OrderDetails'], true);
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
