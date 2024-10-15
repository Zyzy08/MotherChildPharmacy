<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'motherchildpharmacy';

// Set the path to store the backup file
$backup_file = __DIR__ . "/bks/{$dbname}_" . date("Y-m-d_H-i-s") . ".sql";
$command = "\"C:/xampp/mysql/bin/mysqldump\" --user={$user} --password={$password} --host={$host} {$dbname} > {$backup_file}";

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
