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

if ($data === null || !isset($data['invoiceID'])) {
    logError("Invalid or missing InvoiceID");
    die(json_encode(['success' => false, 'error' => 'Invalid or missing InvoiceID']));
}

try {
    // Prepare the SQL statement
    $sql = "INSERT INTO sales (InvoiceID) VALUES (?) ON DUPLICATE KEY UPDATE InvoiceID = InvoiceID";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $data['invoiceID']);

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