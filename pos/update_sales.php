<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to log errors
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, 'error.log');
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    logError("Connection failed: " . $conn->connect_error);
    die(json_encode(['success' => false, 'error' => "Connection failed: " . $conn->connect_error]));
}

// Get the raw POST data
$rawData = file_get_contents('php://input');
logError("Received data: " . $rawData);

// Parse the JSON data
$data = json_decode($rawData, true);

if ($data === null) {
    logError("Failed to parse JSON data");
    die(json_encode(['success' => false, 'error' => 'Failed to parse JSON data']));
}

try {
    // Validate required fields
    $requiredFields = ['invoiceID', 'saleDate', 'accountID', 'salesDetails', 'totalItems', 
                       'subtotal', 'tax', 'discount', 'netAmount', 'amountPaid', 'amountChange'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Check if the InvoiceID already exists
    $checkSql = "SELECT InvoiceID FROM sales WHERE InvoiceID = ?";
    $checkStmt = $conn->prepare($checkSql);
    if (!$checkStmt) {
        throw new Exception("Prepare failed for check: " . $conn->error);
    }
    $checkStmt->bind_param("i", $data['invoiceID']);
    if (!$checkStmt->execute()) {
        throw new Exception("Execute failed for check: " . $checkStmt->error);
    }
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // InvoiceID already exists, update the record
        $sql = "UPDATE sales SET SaleDate = ?, AccountID = ?, SalesDetails = ?, TotalItems = ?, 
                Subtotal = ?, Tax = ?, Discount = ?, NetAmount = ?, AmountPaid = ?, AmountChange = ? 
                WHERE InvoiceID = ?";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed for update: " . $conn->error);
        }
        $stmt->bind_param("sisidddddddi", 
            $data['saleDate'],
            $data['accountID'],
            $data['salesDetails'],
            $data['totalItems'],
            $data['subtotal'],
            $data['tax'],
            $data['discount'],
            $data['netAmount'],
            $data['amountPaid'],
            $data['amountChange'],
            $data['invoiceID']
        );
    } else {
        // InvoiceID doesn't exist, insert a new record
        $sql = "INSERT INTO sales (InvoiceID, SaleDate, AccountID, SalesDetails, TotalItems, 
                Subtotal, Tax, Discount, NetAmount, AmountPaid, AmountChange) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed for insert: " . $conn->error);
        }
        $stmt->bind_param("isisidddddd", 
            $data['invoiceID'],
            $data['saleDate'],
            $data['accountID'],
            $data['salesDetails'],
            $data['totalItems'],
            $data['subtotal'],
            $data['tax'],
            $data['discount'],
            $data['netAmount'],
            $data['amountPaid'],
            $data['amountChange']
        );
    }

    // Execute the statement
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    echo json_encode(['success' => true]);
    
    $stmt->close();

} catch (Exception $e) {
    logError("Error in update_sales.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>