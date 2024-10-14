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

// SQL query with JOIN to combine employeeName and employeeLName into employeeFullName
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
    ORDER BY a.created_at DESC
";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

echo json_encode($data);
?>
