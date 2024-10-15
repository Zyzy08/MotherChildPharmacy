<?php
session_start(); // Start the session to access session variables

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'motherchildpharmacy';

// Establish database connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function logAction($conn, $userId, $action, $description, $status)
{
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $logSql = "INSERT INTO audittrail (AccountID, action, description, ip_address, status) VALUES (?, ?, ?, ?, ?)";
    $logStmt = $conn->prepare($logSql);
    $logStmt->bind_param("ssssi", $userId, $action, $description, $ipAddress, $status);
    $logStmt->execute();
    $logStmt->close();
}

// Retrieve the user ID from the session
$sessionAccountID = $_SESSION['AccountID'] ?? null;

// Set the path to store the backup file
$backup_file = __DIR__ . "/bks/{$dbname}_" . date("Y-m-d_H-i-s") . ".sql";
$command = "\"C:/xampp/mysql/bin/mysqldump\" --user={$user} --password={$password} --host={$host} {$dbname} > {$backup_file}";

// Log action before the backup
$action = 'Database Backup';
$description = "Backup initiated for database '$dbname' by user.";
$status = 1; // You can define the status as 'Pending' initially

// Log the outcome
logAction($conn, $sessionAccountID, $action, $description, $status);

// Execute the backup command
exec($command, $output, $return);

// Prepare the JSON response
$response = [
    'status' => $return === 0 ? 'success' : 'error',
    'message' => $return === 0 ? 'Backup successful!' : 'Backup failed!',
    'path' => $return === 0 ? $backup_file : null // Include the file path if successful
];

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>
