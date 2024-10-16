<?php
session_start();

// Database connection
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

function logAction($conn, $userId, $action, $description)
{
    $sql2 = "INSERT INTO audittrail (AccountID, action, description, ip_address) VALUES (?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql2);

    if ($stmt2 === false) {
        die('Error preparing the statement: ' . $conn->error);
    }

    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $stmt2->bind_param("isss", $userId, $action, $description, $ipAddress);

    if (!$stmt2->execute()) {
        die('Error executing the statement: ' . $stmt2->error);
    }

    $stmt2->close();
}

// Check if the user is logged in
if (isset($_SESSION['AccountID'])) {
    $accountID = $_SESSION['AccountID'];

    // Update connected status to 0
    $updateSql = "UPDATE users SET connected = '0' WHERE AccountID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $accountID);

    logAction($conn, $accountID, 'Logout', 'User logged out successfully.');

    if ($updateStmt->execute()) {
        // Check if all users are offline (connected = 0)
        $checkSql = "SELECT COUNT(*) AS online_users FROM users WHERE connected = 1";
        $result = $conn->query($checkSql);
        $row = $result->fetch_assoc();

        if ($row['online_users'] == 0) {
            // Backup logic if all users are offline
            $host = 'localhost';
            $user = 'root';
            $password = '';
            $dbname = 'motherchildpharmacy';

            // Path to store the backup file
            $backup_file = __DIR__ . "\\backuprestore\\bks\\{$dbname}_" . date("Y-m-d_H-i-s") . ".sql";
            $command = "\"C:/xampp/mysql/bin/mysqldump\" --user={$user} --password={$password} --host={$host} {$dbname} > \"{$backup_file}\"";

            // Execute the backup command
            exec($command, $output, $return);

            // Log backup status
            if ($return === 0) {
                logAction($conn, $accountID, 'Automatic Backup', 'As the user was the last to log off, automatic database backup creation was executed successfully.');
            } else {
                logAction($conn, $accountID, 'Backup Failed', 'Automatic database backup failed.');
            }
        }

        // Clear session and destroy
        session_unset();
        session_destroy();

        // Respond with success
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'User signed out successfully'
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update connected status'
        ]);
    }

    $updateStmt->close();
} else {
    // User not logged in
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'No user is logged in'
    ]);
}

$conn->close();
?>