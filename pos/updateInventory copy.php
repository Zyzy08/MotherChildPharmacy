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
        // Prepare the update statement
        $stmt = $conn->prepare("UPDATE inventory SET InStock = GREATEST(InStock - ?, 0) WHERE ItemID = ?");

        // Update inventory for each item
        foreach ($data['items'] as $item) {
            if (!isset($item['ItemID']) || !isset($item['quantity'])) {
                throw new Exception("Missing required item data");
            }

            $stmt->bind_param("ii", $item['quantity'], $item['ItemID']);
            if (!$stmt->execute()) {
                throw new Exception("Error updating inventory for item " . $item['ItemID']);
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
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}