<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => "Connection failed: " . $conn->connect_error]));
}

// Get the raw POST data
$rawData = file_get_contents('php://input');
// Log the raw data
error_log("Received data: " . $rawData);

// Parse the JSON data
$data = json_decode($rawData, true);

if ($data === null) {
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

    // Prepare the SQL statement
    $sql = "INSERT INTO sales (InvoiceID, SaleDate, AccountID, SalesDetails, TotalItems, 
            Subtotal, Tax, Discount, NetAmount, AmountPaid, AmountChange) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
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

    // Execute the statement
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    echo json_encode(['success' => true]);
    
    $stmt->close();

} catch (Exception $e) {
    error_log("Error in update_sales.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>