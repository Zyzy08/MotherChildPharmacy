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
}

// Now delete the sales entry
$stmt = $conn->prepare("DELETE FROM sales WHERE InvoiceID = ?");
$stmt->bind_param("s", $selectedID);

// Execute the delete query
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Data deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting data: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
