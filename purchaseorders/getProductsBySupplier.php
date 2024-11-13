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
        iv.UnitOfMeasure,
        ps.SupplierID  -- Added SupplierID from product_suppliers table
    FROM 
        inventory iv
    JOIN 
        product_suppliers ps ON iv.ItemID = ps.ItemID  -- Join with product_suppliers table to get the SupplierID
    JOIN 
        suppliers s ON ps.SupplierID = s.SupplierID  -- Join with suppliers table to get the supplier details
    WHERE 
        s.SupplierName = '$ID';  -- Filter based on the SupplierName passed in the URL
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
