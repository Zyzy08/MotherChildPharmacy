<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create a PDO instance
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Prepare the SQL query to join the necessary tables and calculate stock values
$sql = "
SELECT
    i.ItemID,
    CONCAT(i.GenericName, ' ', i.BrandName, ' ', i.Mass, i.UnitOfMeasure) AS Description,
    i.InStock AS ThisMonthStock,

    -- SoldThisMonth calculation
    COALESCE(SUM(DISTINCT CASE 
                    WHEN s.Status = 'Sales' 
                         AND MONTH(s.SaleDate) = MONTH(CURDATE()) 
                         AND YEAR(s.SaleDate) = YEAR(CURDATE()) 
                         AND JSON_UNQUOTE(JSON_EXTRACT(s.SalesDetails, '$.\"1\".itemID')) = i.ItemID
                    THEN CAST(JSON_UNQUOTE(JSON_EXTRACT(s.SalesDetails, '$.\"1\".qty')) AS UNSIGNED) 
                    ELSE 0 
                  END), 0)
    + COALESCE(SUM(DISTINCT CASE 
                    WHEN s.Status = 'Sales' 
                         AND MONTH(s.SaleDate) = MONTH(CURDATE()) 
                         AND YEAR(s.SaleDate) = YEAR(CURDATE()) 
                         AND JSON_UNQUOTE(JSON_EXTRACT(s.SalesDetails, '$.\"2\".itemID')) = i.ItemID
                    THEN CAST(JSON_UNQUOTE(JSON_EXTRACT(s.SalesDetails, '$.\"2\".qty')) AS UNSIGNED) 
                    ELSE 0 
                  END), 0) AS SoldThisMonth,

    -- AddedThisMonth calculation
    COALESCE(SUM(DISTINCT CASE WHEN dd.QuantityDelivered > 0 THEN dd.QuantityDelivered ELSE 0 END), 0) AS AddedThisMonth,

    -- LastMonthStock calculation
    (i.InStock + COALESCE(SUM(CASE WHEN dd.QuantityDelivered > 0 THEN dd.QuantityDelivered ELSE 0 END), 0) - 
     COALESCE(SUM(CASE WHEN s.Status = 'Sales' 
                      AND MONTH(s.SaleDate) = MONTH(CURDATE()) 
                      AND YEAR(s.SaleDate) = YEAR(CURDATE()) 
                      AND JSON_UNQUOTE(JSON_EXTRACT(s.SalesDetails, '$.\"1\".itemID')) = i.ItemID 
                      THEN CAST(JSON_UNQUOTE(JSON_EXTRACT(s.SalesDetails, '$.\"1\".qty')) AS UNSIGNED) 
                      ELSE 0 END), 0)) AS LastMonthStock,

    i.PricePerUnit,
    i.Instock * i.PricePerUnit AS TotalValue,

    -- Adjustments calculation using REGEXP to extract the number inside parentheses
    COALESCE(SUM(DISTINCT CASE
                    WHEN gi.ItemID = i.ItemID
                    THEN CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(gi.Reason, '(', -1), ')', 1) AS SIGNED)
                    ELSE 0
                 END), 0) AS Adjustments

FROM inventory i

LEFT JOIN sales s 
    ON (JSON_UNQUOTE(JSON_EXTRACT(s.SalesDetails, '$.\"1\".itemID')) = i.ItemID 
         OR JSON_UNQUOTE(JSON_EXTRACT(s.SalesDetails, '$.\"2\".itemID')) = i.ItemID)
    AND s.Status = 'Sales'

LEFT JOIN delivery_items dd ON dd.ItemID = i.ItemID

LEFT JOIN goodsissue gi ON gi.ItemID = i.ItemID -- Joining goodsissue to get adjustments

WHERE i.Status = 'Active'
GROUP BY i.ItemID, i.GenericName, i.BrandName, i.InStock, i.PricePerUnit;
";

// Execute the query
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Fetch the data
$inventoryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the data as JSON
echo json_encode($inventoryData);
?>