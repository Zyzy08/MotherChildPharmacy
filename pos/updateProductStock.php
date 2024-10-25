<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve JSON data sent from the client
$data = json_decode(file_get_contents("php://input"), true);

// Log the received data for verification
error_log("Received JSON data: " . print_r($data, true));

// Check if data was received and is in correct format
if (empty($data) || !is_array($data)) {
    echo json_encode(["success" => false, "message" => "Invalid data format received"]);
    exit;
}

// Prepare the SQL statement for updating stock
$stmt = $conn->prepare("UPDATE inventory SET InStock = ? WHERE ItemID = ?");
if (!$stmt) {
    error_log("Error preparing statement: " . $conn->error);
    echo json_encode(["success" => false, "message" => "Statement preparation failed"]);
    exit;
}

$allSuccessful = true;
foreach ($data as $item) {
    // Validate new stock value and item ID
    $newStock = isset($item['newStock']) && is_numeric($item['newStock']) ? (int)$item['newStock'] : null;
    $itemId = isset($item['ItemID']) ? (int)$item['ItemID'] : null;

    // Check for null values and log each item
    if ($newStock === null || $itemId === null) {
        $allSuccessful = false;
        error_log("Invalid data for item: " . json_encode($item));
        continue;
    }

    // Bind parameters and execute the query
    $stmt->bind_param("ii", $newStock, $itemId);
    
    if (!$stmt->execute()) {
        $allSuccessful = false;
        error_log("Error executing update for ItemID $itemId: " . $stmt->error);
    } else {
        error_log("Successfully updated ItemID $itemId to new stock: $newStock");
    }
}

$stmt->close();
$conn->close();

if ($allSuccessful) {
    echo json_encode(["success" => true, "message" => "Stock updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating stock for some items"]);
}
?>
