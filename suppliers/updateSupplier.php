<?php
header('Content-Type: application/json');

function logAction($pdo, $userId, $action, $description, $status)
{
    $sql2 = "INSERT INTO audittrail (AccountID, action, description, ip_address, status) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $pdo->prepare($sql2);
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $stmt2->execute([$userId, $action, $description, $ipAddress, $status]);
}
session_start(); // Start the session
$sessionAccountID = $_SESSION['AccountID'] ?? null;

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $supplierID = isset($_POST["supplierID"]) ? trim($_POST["supplierID"]) : null;
    $companyName = isset($_POST["companyName"]) ? trim($_POST["companyName"]) : null;
    $agentName = isset($_POST["agentName"]) ? trim($_POST["agentName"]) : null;
    $ContactNo = isset($_POST["ContactNo"]) ? trim($_POST["ContactNo"]) : null;
    $Email = isset($_POST["Email"]) ? trim($_POST["Email"]) : null;
    $Notes = isset($_POST["Notes"]) ? trim($_POST["Notes"]) : null;
    $selectedProducts = isset($_POST["selectedProducts"]) ? json_decode(trim($_POST["selectedProducts"]), true) : [];

    // Check if all required fields are present
    if (!$supplierID || !$companyName || !$agentName || !$ContactNo || !$Email) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit();
    }

    try {
        require_once "../users/databaseHandler.php";

        // Prepare the SQL UPDATE statement for the suppliers table
        $sql = "UPDATE suppliers SET SupplierName = ?, AgentName = ?, Phone = ?, Email = ?, Notes = ? WHERE SupplierID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$companyName, $agentName, $ContactNo, $Email, $Notes, $supplierID]);

        // Update product SupplierID based on selected products
        if (!empty($selectedProducts)) {
            foreach ($selectedProducts as $product) {
                $productId = $product['productId'];
                $value = $product['value']; // 1 if checked, 0 if unchecked

                // Prepare the SQL UPDATE for each product
                $updateProductsSql = "UPDATE inventory SET SupplierID = ? WHERE ItemID = ?";
                $updateProductsStmt = $pdo->prepare($updateProductsSql);

                // Set SupplierID to supplierID if checked, otherwise set it to NULL
                $updateProductsStmt->execute([$value ? $supplierID : null, $productId]);
            }
        }

        // Return success if all updates were executed without errors
        $updatedetails = "(SupplierID: " . $supplierID . ")";

        $description = "User updated a supplier $updatedetails.";
        // Log success
        logAction($pdo, $sessionAccountID, 'Update Supplier', $description, 1);

        echo json_encode(['success' => true, 'message' => 'Data updated successfully.']);
        exit();
    } catch (PDOException $e) {
        // Log failure
        $description = "Failed to updated a supplier. Error: " . $e->getMessage();
        logAction($pdo, $sessionAccountID, 'Update Supplier', $description, 0);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}
