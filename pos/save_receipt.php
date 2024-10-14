<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the JSON data from the request body
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Validate required fields
    $required_fields = ['invoiceID', 'accountID', 'saleDate', 'salesDetails', 'totalItems', 'subtotal', 'tax', 'discount', 'netAmount', 'amountPaid', 'amountChange', 'paymentMethod', 'status', 'refundAmount'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field])) {
            echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
            exit;
        }
    }

    // Prepare SQL statement to insert data
    $stmt = $conn->prepare("INSERT INTO sales (InvoiceID, AccountID, SaleDate, SalesDetails, TotalItems, Subtotal, Tax, Discount, NetAmount, AmountPaid, AmountChange, PaymentMethod, Status, RefundAmount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    // Bind the parameters
    $stmt->bind_param("iissiddddddssd", 
        $data['invoiceID'],
        $data['accountID'],
        $data['saleDate'],
        $data['salesDetails'],
        $data['totalItems'],
        $data['subtotal'],
        $data['tax'],
        $data['discount'],
        $data['netAmount'],
        $data['amountPaid'],
        $data['amountChange'],
        $data['paymentMethod'],
        $data['status'],
        $data['refundAmount']
    );

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Receipt saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error saving receipt: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>