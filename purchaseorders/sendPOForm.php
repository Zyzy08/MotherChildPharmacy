<?php
session_start(); // Start the session
$accountID = $_SESSION['AccountID'];

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    require_once "../users/databaseHandler.php"; // Ensure you have a database connection setup in this file

    // Retrieve POST data
    $supplierName = $_POST["supplierSelect"];
    $orderDetails = $_POST["orderDetails"];
    $totalItems = $_POST["totalItems"];

    if (isset($_POST['orderDetails'])) {
        $orderDetails = json_decode($orderDetails, true); // Decode JSON to associative array
    }

    // Prepare to get SupplierID based on SupplierName
    $sqlSupplier = "SELECT SupplierID FROM suppliers WHERE SupplierName = ?";
    $stmtSupplier = $pdo->prepare($sqlSupplier);
    $stmtSupplier->execute([$supplierName]);
    $supplierID = $stmtSupplier->fetchColumn();

    if ($supplierID === false) {
        echo json_encode(['success' => false, 'message' => 'Supplier not found.']);
        exit();
    }

    // Prepare to insert into purchaseorders
    $sql = "INSERT INTO purchaseorders (SupplierID, AccountID, OrderDetails, TotalItems) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Execute the statement
    try {
        $stmt->execute([$supplierID, $accountID, $orderDetails, $totalItems]);
        
        $orderDetailsArray = json_decode($orderDetails, true); // Decode JSON to associative array

        // Now update the inventory
        foreach ($orderDetailsArray as $detail) {
            $itemID = $detail['itemID'];
            $quantity = $detail['qty'];

            // Prepare the update statement for the inventory table
            $sqlUpdate = "UPDATE inventory SET Ordered = Ordered + ? WHERE ItemID = ?";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([$quantity, $itemID]);
        }

        echo json_encode(['success' => true, 'message' => 'Purchase order added and inventory updated successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error adding purchase order: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
