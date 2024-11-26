<?php
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Function to log actions
function logAction($conn, $userId, $action, $description, $status)
{
    $ipAddress = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user
    $logSql = "INSERT INTO audittrail (AccountID, action, description, ip_address, status) VALUES (?, ?, ?, ?, ?)";
    
    // Prepare the SQL statement
    $logStmt = $conn->prepare($logSql);
    
    // Bind parameters to the statement
    $logStmt->bind_param("ssssi", $userId, $action, $description, $ipAddress, $status);
    
    // Execute the statement
    $logStmt->execute();
    
    // Close the statement
    $logStmt->close();
}

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get and decode JSON data
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Only validate that required fields are present
    if (!isset($data['itemID']) || !isset($data['lotNumber']) || !isset($data['quantity'])) {
        throw new Exception("Missing required data");
    }

    $itemID = (int)$data['itemID'];
    $lotNumber = $data['lotNumber'];
    $quantity = (int)$data['quantity'];
    
    // Get current quantity to compare
    $checkSql = "SELECT QuantityRemaining FROM delivery_items WHERE LotNumber = ? AND ItemID = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("si", $lotNumber, $itemID);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $currentQty = $result->fetch_assoc()['QuantityRemaining'];
    
    // Calculate the adjustment amount
    $adjustment = $quantity - $currentQty;
    if ($adjustment > 0) {
        $reason = "Positive adjustment (+{$adjustment}) for lot: {$lotNumber}";
    } else if ($adjustment < 0) {
        $reason = "Negative adjustment ({$adjustment}) for lot: {$lotNumber}";
    } else {
        $reason = "No adjustment (0) for lot: {$lotNumber}";
    }
    
    $timestamp = date('Y-m-d H:i:s');

    // Get the current user's AccountID from the session (assuming the user is logged in)
    session_start();
    $userId = $_SESSION['AccountID'] ?? null;
    
    // Start transaction
    $conn->begin_transaction();

    try {
        // Update delivery_items
        $updateSql = "UPDATE delivery_items 
                     SET QuantityRemaining = ? 
                     WHERE LotNumber = ? AND ItemID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("isi", $quantity, $lotNumber, $itemID);
        
        if (!$updateStmt->execute()) {
            throw new Exception("Failed to update quantity: " . $conn->error);
        }

        // Insert into goodsissue
        $insertSql = "INSERT INTO goodsissue (ItemID, Quantity, Reason, Timestamp) 
                     VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("iiss", $itemID, $quantity, $reason, $timestamp);
        
        if (!$insertStmt->execute()) {
            throw new Exception("Failed to log goods issue: " . $conn->error);
        }

        // Update inventory
        $updateInventorySql = "UPDATE inventory 
                             SET InStock = ? 
                             WHERE ItemID = ?";
        $updateInventoryStmt = $conn->prepare($updateInventorySql);
        $updateInventoryStmt->bind_param("ii", $quantity, $itemID);
        
        if (!$updateInventoryStmt->execute()) {
            throw new Exception("Failed to update inventory: " . $conn->error);
        }

        // Log the action in the audit trail
        $action = 'Stock Adjustment';
        $description = "Stock adjustment for ItemID: {$itemID}, LotNumber: {$lotNumber}, New Quantity: {$quantity}, Adjustment: {$adjustment}";
        $status = 1; // Success
        logAction($conn, $userId, $action, $description, $status);

        // Commit transaction
        $conn->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Stock updated successfully'
        ]);

    } catch (Exception $e) {
        $conn->rollback();
        
        // Log the failed action in the audit trail
        $action = 'Stock Adjustment';
        $description = "Failed stock adjustment for ItemID: {$itemID}, LotNumber: {$lotNumber}, Attempted Quantity: {$quantity}";
        $status = 0; // Failure
        logAction($conn, $userId, $action, $description, $status);

        throw $e;
    }

} catch (Exception $e) {
    error_log("Error in insertGoodIssue.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>
