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

// SQL query to get sales details from the last year
$sql = "
    SELECT 
        SalesDetails 
    FROM 
        sales 
    WHERE 
        SaleDate >= NOW() - INTERVAL 1 YEAR;  // Changed interval to 1 YEAR
";

$result = $conn->query($sql);

$fastMovingProducts = [];

// Loop through each sale to accumulate quantities
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Parse SalesDetails JSON
        $salesDetails = json_decode($row['SalesDetails'], true);

        // Loop through sales details to get item IDs and quantities
        foreach ($salesDetails as $detail) {
            $itemID = $detail['itemID'];
            $qty = $detail['qty'];

            // If item ID exists in the results, accumulate quantity
            if (isset($fastMovingProducts[$itemID])) {
                $fastMovingProducts[$itemID]['totalSold'] += $qty;
            } else {
                $fastMovingProducts[$itemID] = [
                    'totalSold' => $qty,
                    'itemID' => $itemID
                ];
            }
        }
    }
}

// Now fetch item details for the accumulated fast-moving products
foreach ($fastMovingProducts as &$product) {
    $itemID = $product['itemID'];

    // Fetch specific item details from the inventory
    $sqlItem = "SELECT GenericName, BrandName, PricePerUnit, Mass, UnitOfMeasure FROM inventory WHERE ItemID = '$itemID'";
    $itemResult = $conn->query($sqlItem);

    if ($itemResult->num_rows > 0) {
        $itemData = $itemResult->fetch_assoc();
        
        // Populate product details, ensuring PricePerUnit is formatted as needed
        $product['GenericName'] = $itemData['GenericName'];
        $product['BrandName'] = $itemData['BrandName'];
        $product['PricePerUnit'] = isset($itemData['PricePerUnit']) ? number_format((float)$itemData['PricePerUnit'], 2, '.', '') : '0.00';
        $product['Measurement'] = $itemData['Mass'] . ' ' . $itemData['UnitOfMeasure']; // Combine mass and unit of measure
    }
}

// Convert the associative array to a simple array for JSON response
$fastMovingProductsList = array_values($fastMovingProducts);

// Sort products by totalSold in descending order
usort($fastMovingProductsList, function($a, $b) {
    return $b['totalSold'] - $a['totalSold'];
});

echo json_encode($fastMovingProductsList);

$conn->close();
?>
