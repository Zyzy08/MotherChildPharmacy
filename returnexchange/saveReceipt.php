<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "motherchildpharmacy";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get the JSON data from the request body
    $json_data = file_get_contents('php://input');

    $data = json_decode($json_data, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON: " . json_last_error_msg());
    }

    // Validate required fields
    $required_fields = ['invoiceID', 'salesDetails', 'totalItems', 'paymentMethod', 'status'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Validate PaymentMethod and Status
    $valid_payment_methods = ['Cash', 'GCash'];
    $valid_statuses = ['Sales', 'Return', 'Return/Exchange'];

    if (!in_array($data['paymentMethod'], $valid_payment_methods)) {
        throw new Exception("Invalid PaymentMethod. Must be 'Cash' or 'GCash'.");
    }

    if (!in_array($data['status'], $valid_statuses)) {
        throw new Exception("Invalid Status. Must be 'Sales', 'Return', or 'Return/Exchange'.");
    }

    // Convert salesDetails to JSON string
    $salesDetailsJson = json_encode($data['salesDetails']);
    if ($salesDetailsJson === false) {
        throw new Exception("Failed to encode salesDetails as JSON");
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO sales (InvoiceID, SaleDate, AccountID, SalesDetails, TotalItems, Subtotal, Tax, Discount, AmountPaid, PaymentMethod, Status, RefundAmount) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("isisiddddssd", 
        $data['invoiceID'],
        $data['saleDate'],
        $data['accountID'],
        $salesDetailsJson,  // Use the JSON string here
        $data['totalItems'],
        $data['subtotal'],
        $data['tax'],
        $data['discount'],
        $data['amountPaid'],
        $data['paymentMethod'],
        $data['status'],
        $data['refundAmount']
    );

    // Execute the statement
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error . ". SQL State: " . $stmt->sqlstate);
    }

    echo json_encode(['success' => true]);

    // Close statement and connection
    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>