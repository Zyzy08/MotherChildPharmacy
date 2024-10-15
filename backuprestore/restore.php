<?php
session_start(); // Start the session to access session variables

if (isset($_FILES['sqlFile'])) {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "motherchildpharmacy";

    // Establish database connection
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $filePath = $_FILES['sqlFile']['tmp_name'];

    // Command to import the SQL file into the database
    $command = "\"C:/xampp/mysql/bin/mysql\" --user={$user} --password={$pass} --host={$host} {$dbname} < {$filePath}";

    // Execute the command
    exec($command, $output, $returnVar);

    // Prepare the JSON response
    $response = [
        'status' => $returnVar === 0 ? 'success' : 'error',
        'message' => $returnVar === 0 ? 'Database was restored successfully!' : 'Restore failed!'
    ];

    // Log action after restoring the database
    $sessionAccountID = $_SESSION['AccountID'] ?? null;
    $action = 'Database Restore';
    $description = "Database '$dbname' restored by user.";
    $status = $returnVar === 0 ? 1 : 0;

    // Call logAction function to log the action
    logAction($conn, $sessionAccountID, $action, $description, $status);

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the database connection
    $conn->close();
} else {
    // No file selected
    $response = [
        'status' => 'error',
        'message' => 'No file selected.'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Function to log actions
function logAction($conn, $userId, $action, $description, $status)
{
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $logSql = "INSERT INTO audittrail (AccountID, action, description, ip_address, status) VALUES (?, ?, ?, ?, ?)";
    $logStmt = $conn->prepare($logSql);
    $logStmt->bind_param("ssssi", $userId, $action, $description, $ipAddress, $status);
    $logStmt->execute();
    $logStmt->close();
}
?>