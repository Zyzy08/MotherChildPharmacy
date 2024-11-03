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
session_start(); // Start the session to access user data
$sessionAccountID = $_SESSION['AccountID'] ?? null;

$data = json_decode(file_get_contents('php://input'), true);
$selectedID = $data['selectedID'] ?? '';

if (empty($selectedID)) {
    echo json_encode(['success' => false, 'message' => 'Identifier is required.']);
    exit;
}

// Prepare to get the SalesDetails first
$stmt = $conn->prepare("SELECT SalesDetails FROM sales WHERE InvoiceID = ?");
$stmt->bind_param("s", $selectedID);
$stmt->execute();
$stmt->bind_result($salesDetailsJson);
$stmt->fetch();
$stmt->close();

if (!$salesDetailsJson) {
    echo json_encode(['success' => false, 'message' => 'No sales details found for the provided InvoiceID.']);
    exit;
}

// Decode the SalesDetails JSON
$salesDetails = json_decode($salesDetailsJson, true);

// Restore stock for each item in the inventory
foreach ($salesDetails as $detail) {
    $itemID = $detail['itemID'];
    $qty = $detail['qty'];

    // Prepare to update InStock in the inventory table
    $updateStmt = $conn->prepare("UPDATE inventory SET InStock = InStock + ? WHERE ItemID = ?");
    $updateStmt->bind_param("is", $qty, $itemID);
    $updateStmt->execute();
    $updateStmt->close();

    // Get the latest DeliveryID for the given ItemID
    $latestDeliveryStmt = $conn->prepare("
        SELECT DeliveryID 
        FROM delivery_items 
        WHERE ItemID = ? 
        ORDER BY DeliveryID DESC 
        LIMIT 1
    ");
    $latestDeliveryStmt->bind_param("i", $itemID);
    $latestDeliveryStmt->execute();
    $latestDeliveryStmt->bind_result($latestDeliveryID);
    $latestDeliveryStmt->fetch();
    $latestDeliveryStmt->close();

    if ($latestDeliveryID) {
        // Update the QuantityRemaining in the latest DeliveryID record
        $updateDeliveryStmt = $conn->prepare("
            UPDATE delivery_items 
            SET QuantityDelivered = QuantityDelivered + ? 
            WHERE DeliveryID = ? AND ItemID = ?
        ");
        $updateDeliveryStmt->bind_param("iii", $qty, $latestDeliveryID, $itemID);
        $updateDeliveryStmt->execute();
        $updateDeliveryStmt->close();
    }
}

// Now delete the sales entry
$stmt = $conn->prepare("DELETE FROM sales WHERE InvoiceID = ?");
$stmt->bind_param("s", $selectedID);

// Execute the delete query
if ($stmt->execute()) {
    $updatedetails = "(Invoice ID: IN-0" . $selectedID . ")";
    //Log if Success
    $description = "User voided a transaction $updatedetails.";
    logAction($conn, $sessionAccountID, 'Void Transaction', $description, 1);
    echo json_encode(['success' => true, 'message' => 'Data deleted successfully.']);
} else {
    //Log if Fail
    $description = "User failed to void a transaction. Error: " . $stmt->error;
    logAction($conn, $sessionAccountID, 'Void Transaction', $description, 0);
    echo json_encode(['success' => false, 'message' => 'Error deleting data: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>