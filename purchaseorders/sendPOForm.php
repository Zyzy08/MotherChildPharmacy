<?php
session_start(); // Start the session
$accountID = $_SESSION['AccountID'];

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    require_once "../users/databaseHandler.php"; // Ensure you have a database connection setup in this file

    // Retrieve POST data
    $supplierName = $_POST["supplierSelect"];
    $orderDetails = $_POST["orderDetails"]; // This should be a JSON string
    if (isset($_POST['orderDetails'])) {
        $orderDetails = json_decode($_POST['orderDetails'], true); // Decode JSON to associative array
        // Now you can work with $orderDetails as an array
    }

    $totalItems = $_POST["totalItems"]; // Total quantity of items, you need to calculate this

    // Decode the order details JSON to process it
    $orderDetailsArray = json_decode($orderDetails, true);

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
        echo json_encode(['success' => true, 'message' => 'Purchase order added successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error adding purchase order: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
