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
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$searchQuery = $_POST['searchQuery'] ?? '';

// Prepare the SQL statement with a placeholder
$sql = "SELECT employeeName, role, accountName, password, picture, DATE(dateCreated) AS dateCreated, status FROM accounts WHERE employeeName LIKE ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL statement.']);
    exit;
}

// Bind parameters
$likeQuery = '%' . $searchQuery . '%';
$stmt->bind_param('s', $likeQuery);

// Execute the statement
$stmt->execute();

// Fetch results
$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close connections
$stmt->close();
$conn->close();

// Send JSON response
echo json_encode(['success' => true, 'results' => $data]);
?>
