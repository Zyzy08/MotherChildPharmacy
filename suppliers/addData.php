<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = ['success' => false, 'message' => ''];

function logAction($pdo, $userId, $action, $description, $status)
{
    $sql2 = "INSERT INTO audittrail (AccountID, action, description, ip_address, status) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $pdo->prepare($sql2);
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $stmt2->execute([$userId, $action, $description, $ipAddress, $status]);
}
session_start(); // Start the session
$sessionAccountID = $_SESSION['AccountID'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $companyName = trim($_POST["companyName"] ?? '');
    $agentName = trim($_POST["agentName"] ?? '');
    $ContactNo = trim($_POST["ContactNo"] ?? '');
    $Email = trim($_POST["Email"] ?? '');
    $Notes = trim($_POST["Notes"] ?? '');

    // Validate inputs
    if (empty($companyName) || empty($ContactNo)) {
        $response['message'] = 'Company name and Contact No. are required.';
        echo json_encode($response);
        exit();
    }

    // Decode selected products from JSON
    $selectedProducts = json_decode($_POST['selectedProducts'], true);

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "motherchildpharmacy";

    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert new supplier
        $sql = "INSERT INTO suppliers (SupplierName, AgentName, Phone, Email, Notes) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$companyName, $agentName, $ContactNo, $Email, $Notes]);

        // Get the last inserted SupplierID
        $supplierId = $pdo->lastInsertId();

        // Log the new SupplierID
        error_log('New SupplierID: ' . $supplierId);

        // Check if supplierId is valid
        if ($supplierId) {
            // Update SupplierID for selected products
            if (!empty($selectedProducts)) {
                $updateSql = "UPDATE inventory SET SupplierID = ? WHERE ItemID = ?";
                $updateStmt = $pdo->prepare($updateSql);

                foreach ($selectedProducts as $product) {
                    if (isset($product['productId'])) {
                        $result = $updateStmt->execute([$supplierId, $product['productId']]);
                        if (!$result) {
                            error_log('Update failed for ItemID: ' . $product['productId']);
                            $errorInfo = $updateStmt->errorInfo();
                            error_log('SQLSTATE: ' . $errorInfo[0] . ', Error Code: ' . $errorInfo[1] . ', Message: ' . $errorInfo[2]);
                        } else {
                            error_log('Successfully updated ItemID: ' . $product['productId'] . ' with SupplierID: ' . $supplierId);
                        }
                    } else {
                        error_log('Product ID is not set in selectedProducts: ' . print_r($product, true));
                    }
                }
            } else {
                error_log('No products selected for updating SupplierID.');
            }
        } else {
            $response['message'] = 'Failed to retrieve SupplierID after insert.';
        }

        // Return success response
        $updatedetails = "(SupplierID: " . $supplierId . ")";

        $description = "User added a new supplier $updatedetails.";
        // Log success
        logAction($pdo, $sessionAccountID, 'Add Supplier', $description, 1);

        $response['success'] = true;
        $response['message'] = 'Supplier has been added and products updated successfully.';
    } catch (PDOException $e) {
        // Log the error
        error_log('Database query failed: ' . $e->getMessage());
        // Log failure
        $description = "Failed to add new supplier. Error: " . $e->getMessage();
        logAction($pdo, $sessionAccountID, 'Add Supplier', $description, 0);
        $response['message'] = 'Data was not added due to an error.';
    } catch (Exception $e) {
        // Log the unexpected error
        error_log('Unexpected error: ' . $e->getMessage());
        // Log failure
        $description = "Failed to add new supplier. Error: " . $e->getMessage();
        logAction($pdo, $sessionAccountID, 'Add Supplier', $description, 0);
        $response['message'] = 'An unexpected error occurred.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Return the JSON response
echo json_encode($response);
exit();
