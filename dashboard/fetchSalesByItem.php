<?php
// Database connection setup
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

// SQL query
$sql = "
WITH SalesItemDetails AS (
    SELECT 
        CAST(REPLACE(JSON_EXTRACT(SalesDetails, '$.\"1\".itemID'), '\"', '') AS UNSIGNED) AS ItemID,
        CAST(JSON_EXTRACT(SalesDetails, '$.\"1\".qty') AS UNSIGNED) AS QuantitySold,
        CAST(JSON_EXTRACT(SalesDetails, '$.\"1\".price') AS DECIMAL(10,2)) AS PricePerUnit,
        s.Discount
    FROM sales s
    WHERE DATE(s.SaleDate) = CURRENT_DATE
)
SELECT 
    sid.ItemID,
    sid.QuantitySold,
    sid.PricePerUnit,
    (sid.QuantitySold * sid.PricePerUnit) AS Subtotal,
    sid.Discount AS DiscountGiven,
    (sid.QuantitySold * sid.PricePerUnit - sid.Discount) AS NetSales,
    CASE WHEN i.VAT_exempted = 1 
         THEN (sid.QuantitySold * sid.PricePerUnit) 
         ELSE 0 
    END AS VATExemptSales,
    CASE WHEN i.VAT_exempted = 0 
         THEN (sid.QuantitySold * sid.PricePerUnit) 
         ELSE 0 
    END AS VatableSales
FROM SalesItemDetails sid
JOIN inventory i ON sid.ItemID = i.ItemID;
";

// Execute query and get result
$result = $conn->query($sql);

// Check if any data was returned
$data = [];
if ($result->num_rows > 0) {
    // Loop through the rows and populate the data array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Prepare the response in DataTables format
$response = [
    "draw" => isset($_GET['draw']) ? intval($_GET['draw']) : 1,
    "recordsTotal" => $result->num_rows,
    "recordsFiltered" => $result->num_rows,
    "data" => $data
];

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close connection
$conn->close();
?>
