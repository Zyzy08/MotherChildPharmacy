<?php
// Database connection
$host = 'localhost';
$dbname = 'motherchildpharmacy';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to get InStock, Ordered, BrandName, and GenericName for all items
    $stmt = $pdo->prepare("SELECT ItemID, BrandName, GenericName, InStock, Ordered FROM inventory");
    $stmt->execute();
    
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Filter to get only low stock items
    $lowStockItems = array_filter($items, function($item) {
        $inStock = (int)$item['InStock'];
        $ordered = (int)$item['Ordered'];
        $reorderLevel = $ordered * 0.5; // Calculate ReorderLevel

        return $inStock <= $reorderLevel; // Return true if inStock is below or equal to reorderLevel
    });

    // Return only low stock items
    echo json_encode(array_values($lowStockItems));
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>