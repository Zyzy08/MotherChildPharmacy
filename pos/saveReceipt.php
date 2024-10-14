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
    die(json_encode(['success' => false, 'error' => "Connection failed: " . $conn->connect_error]));
}

// Get the JSON data from the request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Prepare the SQL statement
$sql = "INSERT INTO sales (AccountID, AmountChange, AmountPaid, Discount, InvoiceID, NetAmount, PaymentMethod, RefundAmount, SaleDate, SalesDetails, Status, Subtotal, Tax, TotalItems) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die(json_encode(['success' => false, 'error' => "Prepare failed: " . $conn->error]));
}

// Bind parameters
$stmt->bind_param("idddiidssssddi", 
    $data['accountID'],
    $data['amountChange'],
    $data['amountPaid'],
    $data['discount'],
    $data['invoiceID'],
    $data['netAmount'],
    $data['paymentMethod'],
    $data['refundAmount'],
    $data['saleDate'],
    $data['salesDetails'],
    $data['status'],
    $data['subtotal'],
    $data['tax'],
    $data['totalItems']
);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => "Execute failed: " . $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>