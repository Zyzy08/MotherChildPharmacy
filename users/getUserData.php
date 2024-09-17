<?php
header('Content-Type: application/json');

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

// Check if 'accountName' is set in the query string
if (isset($_GET['accountName'])) {
    $accountName = $conn->real_escape_string($_GET['accountName']);
    
    $sql = "SELECT employeeName, employeeLName, role, accountName, password, picture, AccountID, SuppliersPerms, TransactionsPerms, InventoryPerms, POSPerms, REPerms, POPerms, UsersPerms FROM users WHERE accountName = '$accountName'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        $data = null;
    }
    
    echo json_encode($data);
} else {
    echo json_encode(null);
}

$conn->close();
?>
