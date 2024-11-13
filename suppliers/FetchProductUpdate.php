<?php
// FetchProductUpdate.php

// Database connection settings
$host = 'localhost';
$db = 'motherchildpharmacy';
$user = 'root';
$pass = '';

header('Content-Type: application/json'); // Set content type to JSON

try {
    // Check if the supplierID parameter is provided
    if (!isset($_GET['supplierID'])) {
        throw new Exception('SupplierID is required.');
    }

    // Get and validate the supplierID from the GET request
    $supplierID = $_GET['supplierID'];
    if (!filter_var($supplierID, FILTER_VALIDATE_INT)) {
        throw new Exception('Invalid SupplierID.');
    }

    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL statement to fetch products, including those without a SupplierID
    $sql = "
    SELECT 
        i.ItemID, 
        i.GenericName, 
        i.BrandName, 
        i.PricePerUnit, 
        ps.SupplierID,
        -- Check if the product has a supplierID matching the provided supplier, otherwise NULL (unchecked)
        CASE 
            WHEN ps.SupplierID = :supplierID THEN 1 
            ELSE 0 
        END AS isChecked
    FROM inventory i
    LEFT JOIN product_suppliers ps ON i.ItemID = ps.ItemID 
    AND ps.SupplierID = :supplierID -- Only look for matching SupplierID
    WHERE i.Status != 'Archived'
    ORDER BY isChecked DESC, i.ItemID; -- Prioritize checked items first, then order by ItemID
";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':supplierID', $supplierID, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the products
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return an empty array with a message if no products are found
    if (empty($products)) {
        echo json_encode(['success' => true, 'products' => [], 'message' => 'No products found for this supplier.']);
        exit();
    }

    // Process the products to ensure consistent values
    foreach ($products as &$product) {
        $product['GenericName'] = !empty($product['GenericName']) ? $product['GenericName'] : null;
        $product['BrandName'] = !empty($product['BrandName']) ? $product['BrandName'] : null;
        $product['PricePerUnit'] = isset($product['PricePerUnit']) ? number_format(floatval($product['PricePerUnit']), 2) : '0.00';
    }

    // Return the products in JSON format, including the total count
    echo json_encode(['success' => true, 'products' => $products, 'totalProducts' => count($products)]);

    // Check for JSON encoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON encoding error: ' . json_last_error_msg());
    }
} catch (PDOException $e) {
    // Log or handle PDO-specific errors
    error_log('Database query failed: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database query failed.']);
} catch (Exception $e) {
    // General error handling
    error_log('Error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred.']);
}
?>
