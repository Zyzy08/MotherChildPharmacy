<?php
session_start(); // Ensure the session is active

// Helper function to send JSON responses
function sendResponse($response)
{
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
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

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'motherchildpharmacy';
$conn = new mysqli($host, $user, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    $response = [
        'status' => 'error',
        'message' => 'Database connection failed: ' . $conn->connect_error
    ];
    sendResponse($response);
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

$orderDetails = $_POST["orderDetails"];

if (isset($_POST['orderDetails'])) {
    $orderDetails = json_decode($orderDetails, true); // Decode JSON to associative array
}

$orderDetailsArray = json_decode($orderDetails, true); // Decode JSON to associative array

// Get form data
$formattedID = $_POST['identifierID']; // Should be "PO-01234"
$purchaseOrderID = extractPurchaseOrderID($formattedID);

// Retrieve SupplierID from the purchase order
$getSupplierSQL = "SELECT SupplierID FROM purchaseorders WHERE PurchaseOrderID = ?";
$supplierStmt = $conn->prepare($getSupplierSQL);
$supplierStmt->bind_param("i", $purchaseOrderID);
$supplierStmt->execute();
$supplierResult = $supplierStmt->get_result();

if ($supplierResult->num_rows === 0) {
    $response = [
        'status' => 'error',
        'message' => 'Purchase order not found.'
    ];
    sendResponse($response);
}

$supplierRow = $supplierResult->fetch_assoc();
$supplierID = $supplierRow['SupplierID']; // Fetch the SupplierID

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

// Get the current value of ReceivedItems
$currentReceivedSQL = "
    SELECT ReceivedItems 
    FROM purchaseorders 
    WHERE PurchaseOrderID = ?";
$currentStmt = $conn->prepare($currentReceivedSQL);
$currentStmt->bind_param("i", $purchaseOrderID);
$currentStmt->execute();
$currentResult = $currentStmt->get_result();
$currentRow = $currentResult->fetch_assoc();

$currentReceivedItems = $currentRow['ReceivedItems'] ?? 0; // Default to 0 if NULL

// Calculate new ReceivedItems
$newReceivedItems = $currentReceivedItems + $totalDeliveredItems;

// Update ReceivedItems
$updateOrderSQL2 = "
    UPDATE purchaseorders 
    SET ReceivedItems = ? 
    WHERE PurchaseOrderID = ?";
$orderStmt2 = $conn->prepare($updateOrderSQL2);
$orderStmt2->bind_param("ii", $newReceivedItems, $purchaseOrderID);
$orderStmt2->execute();

// Determine delivery status based on comparison with total ordered
if ($newReceivedItems == $totalItemsOrdered || $newReceivedItems > $totalItemsOrdered) {
    $deliveryStatus = 'Completed';
    // Update purchase order status if fully delivered
    $updateOrderSQL = "
    UPDATE purchaseorders 
    SET Status = 'Received' 
    WHERE PurchaseOrderID = ?";
    $orderStmt = $conn->prepare($updateOrderSQL);
    $totalItemsOrdered = count($orderDetailsArray); // Compare with total items

    $orderStmt->bind_param("i", $purchaseOrderID);
    $orderStmt->execute();
} elseif ($newReceivedItems > 0) {
    $deliveryStatus = 'Partial';
    // Update purchase order status if partially delivered
    $updateOrderSQL = "
        UPDATE purchaseorders 
        SET Status = 'Partially Received' 
        WHERE PurchaseOrderID = ?";
    $orderStmt = $conn->prepare($updateOrderSQL);
    $totalItemsOrdered = count($orderDetailsArray); // Compare with total items

    $orderStmt->bind_param("i", $purchaseOrderID);
    $orderStmt->execute();
} else {
    $deliveryStatus = 'Pending';
}

$stmt->bind_param("iiiss", $purchaseOrderID, $supplierID, $receivedBy, $totalDeliveredItems, $deliveryStatus);

if (!$stmt->execute()) {
    $response = [
        'status' => 'error',
        'message' => 'Failed to insert delivery record: ' . $stmt->error
    ];
    sendResponse($response);
}


$deliveryID = $stmt->insert_id; // Get the last inserted DeliveryID

// Insert each item into `delivery_items` table
$insertItemSQL = "INSERT INTO delivery_items (ItemID, DeliveryID, LotNumber, ExpiryDate, QuantityDelivered, Bonus, NetAmount) VALUES (?, ?, ?, ?, ?, ?, ?)";
$itemStmt = $conn->prepare($insertItemSQL);

// Iterate over delivery items and insert them
foreach ($orderDetailsArray as $detail) {
    $itemID = $detail['itemID'];
    $lotNumber = $detail['lotNo'];
    if($detail['expiryDate'] != ''){
        $expiryDate = date('Y-m-d', strtotime($detail['expiryDate'])); // Convert to MySQL date format
    }
    $quantityDelivered = $detail['qty'];
    $bonusAmt = $detail['bonus'];
    $netAmt = $detail['netAmt'];
    $qtyDeliveredPlusBonus = $detail['qtyTotal'];

    // Ensure no empty values before inserting
    if (!empty($lotNumber) && !empty($expiryDate) && $quantityDelivered > 0) {
        $itemStmt->bind_param("iissiii", $itemID, $deliveryID, $lotNumber, $expiryDate, $quantityDelivered, $bonusAmt, $netAmt);

        if (!$itemStmt->execute()) {
            $response = [
                'status' => 'error',
                'message' => 'Failed to insert item: ' . $itemStmt->error
            ];
            sendResponse($response);
        }

        // Update inventory stock based on quantity delivered
        // Assuming the ordered quantity is also available from the delivery item
        $updateInventorySQL = "
            UPDATE inventory 
            SET InStock = InStock + ?, Ordered = Ordered - ? 
            WHERE ItemID = ?";

        // Assuming 'QuantityOrdered' exists in the item array
        $updateInventoryStmt = $conn->prepare($updateInventorySQL);
        $updateInventoryStmt->bind_param("iii", $qtyDeliveredPlusBonus, $quantityDelivered, $itemID);
        // Execute the statement and handle errors
        if (!$updateInventoryStmt->execute()) {
            $response = [
                'status' => 'error',
                'message' => 'Failed to update inventory: ' . $updateInventoryStmt->error
            ];
            sendResponse($response);
        }
        $updateInventoryStmt->close();
    }
}

// Close all statements and connections
$supplierStmt->close();
$stmt->close();
$itemStmt->close();
$orderStmt->close();
$orderStmt2->close();
$currentStmt->close();

$actiondetails = "(Delivery ID: DE-0" . $deliveryID . ")";
$description = "User successfully received delivery $actiondetails.";
logAction($conn, $receivedBy, 'Received Delivery', $description, 1);

$conn->close();

// Send success response
$response = [
    'status' => 'success',
    'message' => 'Delivery processed successfully.'
];
sendResponse($response);
?>