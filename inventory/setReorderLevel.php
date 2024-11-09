<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Define constants for reorder level calculation
$leadTimeMonths = 1; // Lead time of 1 month
$safetyStockPercent = 0.2; // 20% of monthly demand as safety stock

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get sales details from the last 3 months
$sql = "
    SELECT 
        SalesDetails, SaleDate 
    FROM 
        sales 
    WHERE 
        SaleDate >= NOW() - INTERVAL 3 MONTH;
";

$result = $conn->query($sql);

// Array to store sales data
$productDemandData = [];

// Loop through each sale to accumulate quantities and count unique months
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Parse SalesDetails JSON
        $salesDetails = json_decode($row['SalesDetails'], true);

        // Loop through sales details to get item IDs, quantities, and sale dates
        foreach ($salesDetails as $detail) {
            $itemID = $detail['itemID'];
            $qty = $detail['qty'];
            $saleDate = $row['SaleDate'];  // Date of the sale
            $monthYear = date('Y-m', strtotime($saleDate)); // Format: YYYY-MM (e.g., 2024-11)

            // If item ID exists in the results, accumulate quantity and count unique months
            if (isset($productDemandData[$itemID])) {
                // Accumulate total quantity sold
                $productDemandData[$itemID]['totalSold'] += $qty;

                // Add the unique month-year combination if not already added
                if (!in_array($monthYear, $productDemandData[$itemID]['monthsSold'])) {
                    $productDemandData[$itemID]['monthsSold'][] = $monthYear;
                    $productDemandData[$itemID]['monthsCount'] += 1; // Increment months count
                }
            } else {
                // Initialize data for a new product
                $productDemandData[$itemID] = [
                    'totalSold' => $qty,
                    'itemID' => $itemID,
                    'monthsSold' => [$monthYear], // Store unique months as an array
                    'monthsCount' => 1 // First month of sales for this product
                ];
            }
        }
    }
}

// Update reorder levels in inventory for items with at least 3 months of data
foreach ($productDemandData as $product) {
    $itemID = $product['itemID'];
    $totalSold = $product['totalSold'];
    $monthsCount = $product['monthsCount'];

    // Only update reorder level if there are at least 3 months of sales data
    if ($monthsCount >= 3) {
        // Calculate the average monthly demand over the last 3 months
        $averageMonthlyDemand = $totalSold / 3;

        // Calculate safety stock
        $safetyStock = $averageMonthlyDemand * $safetyStockPercent;

        // Calculate reorder level
        $reorderLevel = ceil(($averageMonthlyDemand * $leadTimeMonths) + $safetyStock);

        // Update reorder level in inventory table for this item
        $updateSql = "UPDATE inventory SET ReorderLevel = ? WHERE ItemID = ? AND Status = 'Active'";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ii", $reorderLevel, $itemID);
        $stmt->execute();
    }
}

// Output a success message
echo json_encode(["message" => "Reorder levels updated based on the last 3 months of sales data."]);

$conn->close();
?>