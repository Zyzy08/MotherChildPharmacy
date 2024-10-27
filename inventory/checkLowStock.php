<?php
// Database connection settings
$host = 'localhost';
$dbname = 'motherchildpharmacy';
$username = 'root';
$password = '';

try {
    // Create a new PDO instance and set error mode
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to get the required fields from the inventory table
    $stmt = $pdo->prepare("SELECT ItemID, BrandName, GenericName, InStock, Ordered, ReorderLevel FROM inventory");
    $stmt->execute();
    
    // Fetch all items as an associative array
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Function to calculate EOQ
    function calculateEOQ($demand, $orderCost, $holdingCost) {
        if ($demand > 0) {
            return sqrt((2 * $demand * $orderCost) / $holdingCost);
        }
        return 0; // Return 0 if demand is 0 or less
    }

    // Filter to get only low stock items and calculate EOQ
    $lowStockItems = array_filter($items, function($item) {
        $inStock = isset($item['InStock']) ? (int)$item['InStock'] : 0; // Default to 0 if not set
        $reorderLevel = isset($item['ReorderLevel']) ? (int)$item['ReorderLevel'] : PHP_INT_MAX; // Default to a large value if not set

        // Calculate EOQ using the function
        $ordered = isset($item['Ordered']) ? (int)$item['Ordered'] : 0; // Default to 0 if not set
        $orderCost = 50; // Example order cost, adjust as needed
        $holdingCost = 2; // Example holding cost per unit, adjust as needed

        // Add EOQ to the item array
        $item['EOQ'] = calculateEOQ($ordered, $orderCost, $holdingCost);

        // Return true if inStock is below reorderLevel
        return $inStock < $reorderLevel;
    });

    // Send the filtered low stock items as a JSON response
    echo json_encode(array_values($lowStockItems));
} catch (PDOException $e) {
    // Return error message as a JSON response
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
}
?>
