<?php
// Database connection settings
$host = 'localhost';
$dbname = 'motherchildpharmacy';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to find the top 10 fast-moving products
    $sql = "
            SELECT 
                i.ItemID,
                i.GenericName,
                i.BrandName,
                i.ItemType,
                CONCAT(i.Mass, ' ', i.UnitOfMeasure) AS Measurement,
                i.PricePerUnit,
                SUM(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(s.SalesDetails, CONCAT('$.', seq.n, '.qty'))), 0)) AS TotalSold
            FROM 
                sales AS s
            JOIN 
                (SELECT n FROM (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) AS seq) AS seq
            ON 
                seq.n < JSON_LENGTH(s.SalesDetails)
            JOIN 
                inventory AS i ON JSON_UNQUOTE(JSON_EXTRACT(s.SalesDetails, CONCAT('$.', seq.n, '.itemID'))) = i.ProductCode
            WHERE 
                s.Status = 'Sales'
            GROUP BY 
                i.ItemID, i.GenericName, i.BrandName, i.ItemType, i.Mass, i.UnitOfMeasure, i.PricePerUnit
            ORDER BY 
                TotalSold DESC  
            LIMIT 10;
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $fastMovingProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    if ($fastMovingProducts) {
        echo json_encode($fastMovingProducts);
    } else {
        echo json_encode([]); // Return an empty array if no products found
    }

} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
