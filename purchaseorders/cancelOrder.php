<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
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

// Get the accountName from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$selectedID = $data['selectedID'] ?? '';

if (empty($selectedID)) {
    echo json_encode(['success' => false, 'message' => 'ID is required.']);
    exit;
}

// Prepare to retrieve the order details
$stmt = $conn->prepare("SELECT OrderDetails FROM purchaseorders WHERE PurchaseOrderID = ?");
$stmt->bind_param("s", $selectedID);
$stmt->execute();
$stmt->bind_result($orderDetails);
$stmt->fetch();
$stmt->close();

if (!$orderDetails) {
    echo json_encode(['success' => false, 'message' => 'Order not found.']);
    exit;
}

// Decode the order details JSON to process it
$orderDetailsArray = json_decode($orderDetails, true);

// Now update the inventory
foreach ($orderDetailsArray as $detail) {
    $itemID = $detail['itemID'];
    $quantity = $detail['qty'];

    // Prepare the update statement for the inventory table
    $sqlUpdate = "UPDATE inventory SET Ordered = Ordered - ? WHERE ItemID = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("is", $quantity, $itemID);
    $stmtUpdate->execute();
}

// Prepare and bind the update statement to cancel the order
$stmtCancel = $conn->prepare("UPDATE purchaseorders SET status = 'Cancelled' WHERE PurchaseOrderID = ?");
$stmtCancel->bind_param("s", $selectedID);
$updatedetails = "(OrderID: PO-0" . $selectedID . ")";

// Execute the cancel query
if ($stmtCancel->execute()) {
    //Log if Success
    $description = "User successfully cancelled an order $updatedetails.";
    logAction($conn, $sessionAccountID, 'Cancel Order', $description, 1);
    echo json_encode(['success' => true, 'message' => 'Order cancelled successfully and inventory updated.']);
} else {
    // Log failure
    $description = "User failed to cancel an order $updatedetails. Error: " . $stmt->error;
    logAction($conn, $sessionAccountID, 'Cancel Order', $description, 0);
    echo json_encode(['success' => false, 'message' => 'Error cancelling order: ' . $stmtCancel->error]);
}

// Close the statements and connection
$stmtCancel->close();
$conn->close();
?>