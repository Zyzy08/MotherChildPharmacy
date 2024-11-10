<?php
header('Content-Type: application/json');
ini_set('log_errors', 1); // Enable logging
ini_set('display_errors', 0); // Disable display errors on screen
ini_set('error_log', 'logfile.txt'); // Path to your log file

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Get the current user's AccountID from the session or other source
session_start();
$sessionAccountID = $_SESSION['AccountID'] ?? null;

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

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    $selectedOrder = $_POST['selectedOrder'];

    if (!isset($_POST['selectedOrder'])) {
        throw new Exception("Order number is required");
    }
    // Start transaction
    $conn->begin_transaction();

    try {
        // Update the inventory status where the InvoiceID matches the selectedOrder
        $stmtUpdateStatus = $conn->prepare("UPDATE sales SET Status = 'Returned' WHERE InvoiceID = ?");
        $stmtUpdateStatus->bind_param("i", $selectedOrder);
        if (!$stmtUpdateStatus->execute()) {
            throw new Exception("Error updating status for order " . $selectedOrder);
        }

        // Prepare to get the SalesDetails first
        $stmt = $conn->prepare("SELECT SalesDetails FROM sales WHERE InvoiceID = ?");
        $stmt->bind_param("i", $selectedOrder);
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
            $itemID = intval($detail['itemID']);
            $qty = intval($detail['qty']);

            // Prepare to update InStock in the inventory table
            $updateStmt = $conn->prepare("UPDATE inventory SET InStock = InStock + ? WHERE ItemID = ?");
            $updateStmt->bind_param("ii", $qty, $itemID);
            $updateStmt->execute();

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
            SET QuantityRemaining = QuantityRemaining + ? 
            WHERE DeliveryID = ? AND ItemID = ?
        ");
                $updateDeliveryStmt->bind_param("iii", $qty, $latestDeliveryID, $itemID);
                $updateDeliveryStmt->execute();
            }
        }


        // Commit transaction
        $conn->commit();

        $updatedetails = "(Invoice ID: IN-0" . $_POST['selectedOrder'] . ")";

        //Log if Success
        $description = "User successfully processed a return $updatedetails.";
        logAction($conn, $sessionAccountID, 'Process Return', $description, 1);

        echo json_encode(['success' => true, 'message' => 'Inventory updated successfully']);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        throw $e;
    }

} catch (Exception $e) {
    error_log('' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    if (isset($stmtSelect)) {
        $stmtSelect->close();
    }
    if (isset($stmtUpdateLot)) {
        $stmtUpdateLot->close();
    }
    if (isset($stmtUpdateInventory)) {
        $stmtUpdateInventory->close();
    }
    if (isset($updateDeliveryStmt)) {
        $updateDeliveryStmt->close();
    }
    if (isset($updateStmt)) {
        $updateStmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
