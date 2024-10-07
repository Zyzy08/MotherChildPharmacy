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
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the last InvoiceID
$sql = "SELECT InvoiceID FROM sales ORDER BY InvoiceID DESC LIMIT 1";
$result = $conn->query($sql);

$newInvoiceID = 1; // Default starting value if no invoice exists

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastInvoiceID = $row['InvoiceID'];

    // Increment the InvoiceID
    $newInvoiceID = $lastInvoiceID + 1;
}

// Return the new InvoiceID as JSON
echo json_encode(['newInvoiceID' => $newInvoiceID]);

// Close the connection
$conn->close();
?>
