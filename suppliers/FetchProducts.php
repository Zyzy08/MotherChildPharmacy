<?php 
// FetchProducts.php

// Database connection settings
$host = 'localhost';
$db = 'motherchildpharmacy';
$user = 'root';
$pass = '';
    
header('Content-Type: application/json'); // Set content type to JSON

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL statement to fetch products with SupplierID not NULL or 0, excluding archived products
    $sql = "SELECT i.ItemID, i.GenericName, i.BrandName, i.PricePerUnit, 
               IFNULL(GROUP_CONCAT(ps.SupplierID), '') AS SupplierIDs
        FROM inventory i
        LEFT JOIN product_suppliers ps ON i.ItemID = ps.ItemID
        WHERE i.Status != 'Archived'
        GROUP BY i.ItemID, i.GenericName, i.BrandName, i.PricePerUnit";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch the products
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Process the products to ensure consistent values
    foreach ($products as &$product) {
        // Set values to null or default if they are empty
        $product['ItemID'] = !empty($product['ItemID']) ? $product['ItemID'] : null;
        $product['GenericName'] = !empty($product['GenericName']) ? $product['GenericName'] : null;
        $product['BrandName'] = !empty($product['BrandName']) ? $product['BrandName'] : null;

        // Convert PricePerUnit to float, defaulting to 0 if null
        $product['PricePerUnit'] = isset($product['PricePerUnit']) ? floatval($product['PricePerUnit']) : 0.0;
    }

    // Return the products in JSON format
    echo json_encode(['success' => true, 'products' => $products]);

    // Check for JSON encoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON encoding error: ' . json_last_error_msg());
    }
} catch (PDOException $e) {
    // Log the database error
    error_log('Database query failed: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database query failed.']);
} catch (Exception $e) {
    // Log other errors
    error_log('Error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
