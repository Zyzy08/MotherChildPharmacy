<?php
// updateProductStock.php - Modified version
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);
error_log("Received stock updates: " . print_r($data, true));

if (!is_array($data)) {
    echo json_encode(["success" => false, "message" => "Invalid data format"]);
    exit;
}

// Start transaction
$conn->begin_transaction();

try {
    $stmt = $conn->prepare("UPDATE inventory SET InStock = ? WHERE ItemID = ? AND InStock >= ?");
    
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    $allSuccessful = true;
    $errors = [];

    foreach ($data as $item) {
        if (!isset($item['ItemID']) || !isset($item['newStock']) || $item['newStock'] < 0) {
            $errors[] = "Invalid data for item: " . json_encode($item);
            continue;
        }

        // Calculate the difference to ensure we have enough stock
        $currentStock = $item['newStock'];
        $itemId = $item['ItemID'];
        
        $stmt->bind_param("iii", $currentStock, $itemId, $currentStock);
        
        if (!$stmt->execute()) {
            $errors[] = "Failed to update ItemID $itemId: " . $stmt->error;
            $allSuccessful = false;
        }
        
        // Check if any rows were actually updated
        if ($stmt->affected_rows === 0) {
            $errors[] = "No update performed for ItemID $itemId - insufficient stock or item not found";
            $allSuccessful = false;
        }
    }

    if (!$allSuccessful) {
        throw new Exception("Some updates failed: " . implode(", ", $errors));
    }

    // If we got here, commit the transaction
    $conn->commit();
    echo json_encode(["success" => true, "message" => "Stock updated successfully"]);

} catch (Exception $e) {
    // Something went wrong, rollback the transaction
    $conn->rollback();
    echo json_encode([
        "success" => false, 
        "message" => "Error updating stock: " . $e->getMessage()
    ]);
}

$stmt->close();
$conn->close();
?>