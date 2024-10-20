<?php
session_start(); // Ensure the session is active

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'motherchildpharmacy';
$conn = new mysqli($host, $user, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function logPostData($data)
{
    $logFile = 'post_data_log.txt'; // Specify the log file name
    $logEntry = date('Y-m-d H:i:s') . " - " . print_r($data, true) . PHP_EOL; // Format the log entry with timestamp
    file_put_contents($logFile, $logEntry, FILE_APPEND); // Append the log entry to the file
}

// Function to extract the numeric part from "PO-01234"
function extractPurchaseOrderID($formattedID)
{
    return intval(substr($formattedID, 3)); // Remove 'PO-' prefix and convert to integer
}

// Get form data
$formattedID = $_POST['identifierID']; // Should be "PO-01234"
$purchaseOrderID = extractPurchaseOrderID($formattedID);

// Retrieve SupplierID from the purchase order
$getSupplierSQL = "SELECT SupplierID FROM purchaseorders WHERE PurchaseOrderID = ?";
$supplierStmt = $conn->prepare($getSupplierSQL);
$supplierStmt->bind_param("i", $purchaseOrderID);
$supplierStmt->execute();
$supplierResult = $supplierStmt->get_result();
$supplierRow = $supplierResult->fetch_assoc();
$supplierID = $supplierRow['SupplierID']; // Fetch the SupplierID

$deliveryItems = json_decode($_POST['orderDetails'], true); // JSON of items delivered
$receivedBy = $_SESSION['AccountID']; // Use current session user

// Insert delivery record into `deliveries` table
$insertDeliverySQL = "
    INSERT INTO deliveries (PurchaseOrderID, SupplierID, ReceivedBy, TotalDeliveredItems, DeliveryStatus) 
    VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertDeliverySQL);

// Calculate total items delivered
$totalDeliveredItems = $_POST['totalItems'];
// Assuming you retrieve total items ordered from the Purchase Orders table
$getTotalOrderedSQL = "SELECT TotalItems FROM purchaseorders WHERE PurchaseOrderID = ?";
$totalOrderedStmt = $conn->prepare($getTotalOrderedSQL);
$totalOrderedStmt->bind_param("i", $purchaseOrderID);
$totalOrderedStmt->execute();
$totalOrderedResult = $totalOrderedStmt->get_result();
$totalOrderedRow = $totalOrderedResult->fetch_assoc();
$totalItemsOrdered = $totalOrderedRow['TotalItems'];

// Determine delivery status based on comparison with total ordered
if ($totalDeliveredItems == $totalItemsOrdered) {
    $deliveryStatus = 'Completed';
    // Update purchase order status if fully delivered
    $updateOrderSQL = "
    UPDATE purchaseorders 
    SET Status = 'Received' 
    WHERE PurchaseOrderID = ?";
    $orderStmt = $conn->prepare($updateOrderSQL);
    $totalItemsOrdered = count($deliveryItems); // Compare with total items

    $orderStmt->bind_param("i", $purchaseOrderID);
    $orderStmt->execute();
} elseif ($totalDeliveredItems > 0) {
    $deliveryStatus = 'Partial';
} else {
    $deliveryStatus = 'Pending';
}

$stmt->bind_param("iiiss", $purchaseOrderID, $supplierID, $receivedBy, $totalDeliveredItems, $deliveryStatus);
$stmt->execute();


$deliveryID = $stmt->insert_id; // Get the last inserted DeliveryID

// log working to this point
logPostData($deliveryID);

// Insert each item into `delivery_items` table
$insertItemSQL = "INSERT INTO delivery_items (ItemID, DeliveryID, LotNumber, ExpiryDate, QuantityDelivered, NetAmount) VALUES (?, ?, ?, ?, ?, ?)";
$itemStmt = $conn->prepare($insertItemSQL);

$orderDetails = json_decode($_POST['orderDetails'], true); // JSON of items delivered

// Iterate over delivery items and insert them
foreach ($orderDetails as $item) {
    $itemID = $item['itemID'];
    $lotNumber = $item['lotNo'];
    $expiryDate = date('Y-m-d', strtotime($item['expiryDate'])); // Convert to MySQL date format
    $quantityDelivered = $item['qty'];
    $netAmt = $item['netAmt'];

    // Ensure no empty values before inserting
    if (!empty($lotNumber) && !empty($expiryDate) && $quantityDelivered > 0) {
        $itemStmt->bind_param("iissii", $itemID, $deliveryID, $lotNumber, $expiryDate, $quantityDelivered, $netAmt);
        $itemStmt->execute();

        // Update inventory stock based on quantity delivered
        // Assuming the ordered quantity is also available from the delivery item
        $updateInventorySQL = "
            UPDATE inventory 
            SET InStock = InStock + ?, Ordered = Ordered - ? 
            WHERE ItemID = ?";

        // Assuming 'QuantityOrdered' exists in the item array
        $updateInventoryStmt = $conn->prepare($updateInventorySQL);
        $updateInventoryStmt->bind_param("iii", $quantityDelivered, $quantityDelivered, $itemID);
        $updateInventoryStmt->execute();
        $updateInventoryStmt->close();
    }
}

// Close all statements and connections
$supplierStmt->close();
$stmt->close();
$itemStmt->close();
$orderStmt->close();
$conn->close();

// Redirect or respond with success message
header("Location: delivery.php");
exit();
?>