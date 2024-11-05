<?php
// Set the header for JSON response
header('Content-Type: application/json');

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

try {
    // Create a new PDO instance and set error mode
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to get sales details from the last year
    $salesQuery = "
        SELECT SalesDetails
        FROM sales
        WHERE SaleDate >= NOW() - INTERVAL 1 YEAR;
    ";

    // Execute the sales query
    $salesResult = $pdo->query($salesQuery);
    $fastMovingProducts = [];

    // Loop through each sale to accumulate quantities
    foreach ($salesResult as $row) {
        $salesDetails = json_decode($row['SalesDetails'], true);
        foreach ($salesDetails as $detail) {
            $itemID = $detail['itemID'];
            $qty = $detail['qty'];
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

    // Fetch item details for accumulated fast-moving products with low stock
    foreach ($fastMovingProducts as &$product) {
        $itemID = $product['itemID'];
        $itemQuery = "
            SELECT GenericName, BrandName, PricePerUnit, Mass, UnitOfMeasure, InStock, Ordered, ReorderLevel
            FROM inventory
            WHERE ItemID = :itemID AND InStock <= ReorderLevel
        ";
        $itemStmt = $pdo->prepare($itemQuery);
        $itemStmt->bindParam(':itemID', $itemID, PDO::PARAM_INT);
        $itemStmt->execute();
        $itemData = $itemStmt->fetch(PDO::FETCH_ASSOC);

        if ($itemData) {
            // Populate product data
            $product['GenericName'] = $itemData['GenericName'];
            $product['BrandName'] = $itemData['BrandName'];
            $product['PricePerUnit'] = number_format((float)$itemData['PricePerUnit'], 2, '.', '');
            $product['Measurement'] = $itemData['Mass'] . ' ' . $itemData['UnitOfMeasure'];
            $product['InStock'] = $itemData['InStock'];
            $product['Ordered'] = $itemData['Ordered'];
            
            // Calculate EOQ if totalSold is greater than zero
            if ($product['totalSold'] > 0) {
                $orderingCost = 50; // Adjust based on your needs
                $holdingCost = 2;   // Adjust based on your needs
                $product['EOQ'] = round(sqrt((2 * $product['totalSold'] * $orderingCost) / $holdingCost), 2);
            } else {
                $product['EOQ'] = 0;
            }
        } else {
            unset($fastMovingProducts[$itemID]); // Remove item if it doesn't meet low-stock criteria
        }
    }

    // Convert associative array to a simple array for JSON response
    echo json_encode(array_values($fastMovingProducts));

} catch (PDOException $e) {
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
}
?>
