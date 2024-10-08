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

// Check if 'ID' is set in the query string
if (isset($_GET['ID'])) {
    $ID = $conn->real_escape_string($_GET['ID']);
    
    // Updated SQL query with JOIN
    $sql = "
    SELECT
        iv.ItemID, 
        iv.GenericName,
        iv.BrandName,
        iv.Mass,
        iv.UnitOfMeasure
    FROM 
        inventory iv
    JOIN 
        suppliers s ON iv.SupplierID = s.SupplierID
    WHERE 
        s.SupplierName = '$ID';
    ";
    
    
    $result = $conn->query($sql);
    
    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; // Collect all rows
        }
    }
    
    echo json_encode($data);
} else {
    echo json_encode([]);
}

$conn->close();
?>
