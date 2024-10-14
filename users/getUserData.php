<?php
header('Content-Type: application/json');

// Function to log actions
function logAction($conn, $userId, $action, $description) {
    // Prepare the SQL statement
    $sql2 = "INSERT INTO audittrail (AccountID, action, description, ip_address) VALUES (?, ?, ?, ?)";
    
    // Create a prepared statement
    $stmt2 = $conn->prepare($sql2);
    
    // Check if the statement was prepared correctly
    if ($stmt2 === false) {
        die('Error preparing the statement: ' . $conn->error);
    }
    
    // Bind the parameters
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $stmt2->bind_param("isss", $userId, $action, $description, $ipAddress);
    
    // Execute the statement
    if (!$stmt2->execute()) {
        die('Error executing the statement: ' . $stmt2->error);
    }

    // Close the statement
    $stmt2->close();
}

// Start the session to access session variables
session_start();

// Database configuration
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
    
    $sql = "SELECT AccountID, employeeName, employeeLName, role, accountName, password, picture, AccountID, SuppliersPerms, TransactionsPerms, InventoryPerms, POSPerms, REPerms, POPerms, UsersPerms FROM users WHERE accountName = '$accountName'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        // Log the action of viewing user details
        $sessionAccountID = $_SESSION['AccountID'] ?? null; // Get the AccountID from the session
        logAction($conn, $sessionAccountID, 'View User Details', 'Viewed details for account: ' . $accountName);
    } else {
        $data = null;
    }
    
    echo json_encode($data);
} else {
    echo json_encode(null);
}

$conn->close();
?>
