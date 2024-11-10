<?php
// Database connection parameters
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

// Get the search query
$searchQuery = isset($_POST['query']) ? $_POST['query'] : '';

// Prepare the SQL statement to fetch products
$sql = "SELECT ItemID, BrandName, GenericName, Mass, UnitOfMeasure, InStock, PricePerUnit, ProductIcon, ProductCode, ReorderLevel, Discount, VAT_exempted, Status 
        FROM inventory";

if ($searchQuery) {
    $sql .= " WHERE (BrandName LIKE ? OR GenericName LIKE ? OR ProductCode LIKE ?)";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $searchQuery . "%";
    $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Output the products as a comment
echo '<!-- ' . json_encode($products) . ' -->';

// Close the connection
$conn->close();
?>
