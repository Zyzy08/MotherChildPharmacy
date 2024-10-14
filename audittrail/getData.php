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

// Retrieve auditID from the request
$auditID = isset($_GET['auditID']) ? $_GET['auditID'] : '';

if (!empty($auditID)) {
    $sql = "
        SELECT 
            a.auditID, 
            CONCAT(u.employeeName, ' ', u.employeeLName) AS employeeFullName, 
            a.action, 
            a.description, 
            a.created_at, 
            DATE_FORMAT(a.created_at, '%m/%d/%y (%l:%i %p)') AS formatted_datetime, 
            a.Status 
        FROM audittrail a
        LEFT JOIN users u ON a.AccountID = u.AccountID
        WHERE a.auditID = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $auditID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No data found']);
    }

    $stmt->close();
}

$conn->close();
?>
