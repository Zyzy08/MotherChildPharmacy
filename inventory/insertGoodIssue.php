<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST parameters
    $data = json_decode(file_get_contents("php://input"), true);
    $itemID = isset($data['itemID']) ? (int) $data['itemID'] : 0; // Get the ItemID
    $lotNumber = isset($data['lotNumber']) ? trim($data['lotNumber']) : ''; // Get the selected Lot Number
    $quantity = isset($data['Quantity']) ? (int) $data['Quantity'] : 0; // Quantity input from user
    $reason = isset($data['reason']) ? trim($data['reason']) : '';
    $timestamp = isset($data['timestamp']) ? trim($data['timestamp']) : '';
    $action = isset($data['action']) ? trim($data['action']) : 'add'; // Add or subtract action

    // Validate parameters
    if ($itemID <= 0) {
        echo json_encode(['message' => "Invalid ItemID."]);
        exit;
    }
    if ($quantity <= 0) {
        echo json_encode(['message' => "Invalid quantity."]);
        exit;
    }
    if (empty($reason)) {
        echo json_encode(['message' => "Reason is required."]);
        exit;
    }
    if (empty($timestamp)) {
        echo json_encode(['message' => "Timestamp is required."]);
        exit;
    }
    if (empty($lotNumber)) {
        echo json_encode(['message' => "Lot number is required."]);
        exit;
    }

    // Get the current user's AccountID from the session or other source
    session_start();
    $sessionAccountID = $_SESSION['AccountID'] ?? null;

    // Log the issue in `goodsissue` including `ItemID`
    $insertSql = "INSERT INTO goodsissue (ItemID, Quantity, Reason, Timestamp) VALUES (?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param('iiss', $itemID, $quantity, $reason, $timestamp); // Bind ItemID

    if ($insertStmt->execute()) {
        // Update QuantityRemaining in delivery_items based on action
        $updateSql = "UPDATE delivery_items SET QuantityRemaining = QuantityRemaining " . ($action === 'add' ? '+' : '-') . " ? WHERE LotNumber = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('is', $quantity, $lotNumber); // Bind quantity and lot number

        if ($updateStmt->execute()) {
            // Update InStock in inventory table
            $updateInventorySql = "UPDATE inventory SET InStock = InStock " . ($action === 'add' ? '+' : '-') . " ? WHERE ItemID = ?";
            $updateInventoryStmt = $conn->prepare($updateInventorySql);
            $updateInventoryStmt->bind_param('ii', $quantity, $itemID); // Bind quantity and ItemID
            $updatedetails = "(ItemID: " . $itemID . ", Quantity: " . $quantity . ")";

            if ($updateInventoryStmt->execute()) {
                //Log if Success
                $description = "User manually adjusted the stock of a product. $updatedetails.";
                logAction($conn, $sessionAccountID, 'Goods Issue', $description, 1);
                echo json_encode(['message' => "Data logged and quantities updated successfully."]);
            } else {
                //Log if Fail
                $description = "User failed to manually adjusted the stock of a product. $updatedetails.";
                logAction($conn, $sessionAccountID, 'Goods Issue', $description, 0);
                echo json_encode(['message' => "Error updating inventory InStock: " . $conn->error]);
            }
            $updateInventoryStmt->close();
        } else {
            echo json_encode(['message' => "Error updating quantity in delivery_items: " . $conn->error]);
        }
        $updateStmt->close();
    } else {
        echo json_encode(['message' => "Error logging issue: " . $conn->error]);
    }
    $insertStmt->close();
}

$conn->close(); // Close the database connection
?>