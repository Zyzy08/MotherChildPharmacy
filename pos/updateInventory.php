<?php
// updateInventory.php
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get the JSON data from the request
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if (!isset($data['items']) || !is_array($data['items'])) {
        throw new Exception("Invalid data format");
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        foreach ($data['items'] as $item) {
            if (!isset($item['ItemID']) || !isset($item['quantity'])) {
                throw new Exception("Missing required item data");
            }

            $itemId = $item['ItemID'];
            $quantityToDeduct = $item['quantity'];

            // Fetch lot data ordered by ExpiryDate for the given ItemID
            $stmtSelect = $conn->prepare("SELECT LotNumber, QuantityRemaining FROM delivery_items WHERE ItemID = ? AND QuantityRemaining > 0 ORDER BY ExpiryDate ASC");
            $stmtSelect->bind_param("i", $itemId);
            $stmtSelect->execute();
            $lotResults = $stmtSelect->get_result();

            if ($lotResults->num_rows === 0) {
                throw new Exception("No available stock in lots for item " . $itemId);
            }

            // Iterate through the lots and reduce the quantity
            while ($quantityToDeduct > 0 && $lotRow = $lotResults->fetch_assoc()) {
                $lotNumber = $lotRow['LotNumber'];
                $quantityRemaining = $lotRow['QuantityRemaining'];

                // Calculate the quantity to reduce from this lot
                $quantityToReduce = min($quantityToDeduct, $quantityRemaining);
                $newQuantityRemaining = $quantityRemaining - $quantityToReduce;

                // Update the lot with the new QuantityRemaining
                $stmtUpdateLot = $conn->prepare("UPDATE delivery_items SET QuantityRemaining = ? WHERE ItemID = ? AND LotNumber = ?");
                $stmtUpdateLot->bind_param("iis", $newQuantityRemaining, $itemId, $lotNumber);
                if (!$stmtUpdateLot->execute()) {
                    throw new Exception("Error updating lot " . $lotNumber . " for item " . $itemId);
                }

                // Reduce the remaining quantity to deduct
                $quantityToDeduct -= $quantityToReduce;
            }

            // If there's still quantity left to deduct after all lots, throw an error
            if ($quantityToDeduct > 0) {
                throw new Exception("Not enough stock in lots for item " . $itemId);
            }

            // After updating lots, update the inventory table
            $stmtUpdateInventory = $conn->prepare("UPDATE inventory SET InStock = InStock - ? WHERE ItemID = ?");
            $stmtUpdateInventory->bind_param("ii", $item['quantity'], $itemId);
            if (!$stmtUpdateInventory->execute()) {
                throw new Exception("Error updating inventory for item " . $itemId);
            }
        }

        // Commit transaction
        $conn->commit();

        echo json_encode(['success' => true, 'message' => 'Inventory updated successfully']);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        throw $e;
    }

} catch (Exception $e) {
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
    if (isset($conn)) {
        $conn->close();
    }
}
