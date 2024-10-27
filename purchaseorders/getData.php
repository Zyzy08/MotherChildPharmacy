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

// Get the current user's AccountID from the session or other source
session_start();
$sessionAccountID = $_SESSION['AccountID'] ?? null;

// Check if 'InvoiceID' is set in the query string
if (isset($_GET['InvoiceID'])) {
    $InvoiceID = $conn->real_escape_string($_GET['InvoiceID']);

    // Updated SQL query with JOIN
    $sql = "
    SELECT 
        po.PurchaseOrderID, 
        DATE_FORMAT(po.OrderDate, '%m/%d/%Y') AS OrderDate,
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
            $sqlItem = "SELECT GenericName, BrandName, Mass, UnitOfMeasure FROM inventory WHERE ItemID = '$itemID'";
            $itemResult = $conn->query($sqlItem);
            if ($itemResult->num_rows > 0) {
                $itemData = $itemResult->fetch_assoc();
                $genericName = $itemData['GenericName'];
                $brandName = $itemData['BrandName'];
                $mass = $itemData['Mass'];
                $unitOfMeasure = $itemData['UnitOfMeasure'];

                // Fetch total quantity delivered for the item
                $sqlDelivered = "
                    SELECT SUM(di.QuantityDelivered) AS TotalDelivered 
                    FROM delivery_items di 
                    JOIN deliveries d ON di.DeliveryID = d.DeliveryID 
                    WHERE d.PurchaseOrderID = '$InvoiceID' AND di.ItemID = '$itemID'";
                $deliveredResult = $conn->query($sqlDelivered);
                $deliveredQty = 0; // Default to 0 if no deliveries found
                if ($deliveredResult->num_rows > 0) {
                    $deliveredRow = $deliveredResult->fetch_assoc();
                    $deliveredQty = $deliveredRow['TotalDelivered'] ?? 0; // Use NULL coalescing for safety
                }

                // Calculate pending quantity
                $pendingQty = $qty - $deliveredQty;

                // Add item to the list with Mass, Unit of Measure, and Pending quantity
                $listItems[] = [
                    'description' => "$brandName $genericName ($mass $unitOfMeasure)",
                    'quantity' => $qty,
                    'pending' => $pendingQty // Add the pending quantity here
                ];
            }
        }

        // Add the list of items to the data
        $data['listItems'] = $listItems;
    } else {
        $data = null;
    }

    // $updatedetails = "(OrderID: PO-0" . $InvoiceID . ")";
    //Log if Success
    // $description = "User viewed a purchase order's details $updatedetails.";
    // logAction($conn, $sessionAccountID, 'View Order', $description, 1);
    echo json_encode($data);
} else {
    // Log failure
    // $description = "User failed to view a purchase order. Error: " . $stmt->error;
    // logAction($conn, $sessionAccountID, 'View Order', $description, 0);
    echo json_encode(null);
}

$conn->close();
?>