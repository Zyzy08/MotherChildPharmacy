<?php
header('Content-Type: application/json');

// Check request method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all necessary POST variables are set
    $requiredFields = ['itemName', 'genericName', 'brandName', 'itemType', 'mass', 'unitOfMeasure', 'InStock', 'pricePerUnit', 'notes', 'status'];
    $data = [];
    foreach ($requiredFields as $field) {
        if (isset($_POST[$field])) {
            $data[$field] = $_POST[$field];
        } else {
            echo json_encode(['success' => false, 'message' => "Missing field: $field"]);
            exit();
        }
    }

    // Debugging: print the received data
    error_log(print_r($data, true));

    // Database connection and insertion
    try {
        // Database connection settings
        $host = 'localhost';  // Update with your database host
        $db = 'motherchildpharmacy';  // Update with your database name
        $user = 'root';  // Update with your database username
        $password = '';  // Update with your database password

        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO inventory (ItemName, GenericName, BrandName, ItemType, Mass, UnitOfMeasure, InStock, PricePerUnit, Notes, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$data['itemName'], $data['genericName'], $data['brandName'], $data['itemType'], $data['mass'], $data['unitOfMeasure'], $data['InStock'] , $data['pricePerUnit'], $data['notes'], $data['status']]);

        echo json_encode(['success' => true, 'message' => 'Product added successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Product was not added due to error: ' . $e->getMessage()]);
    } finally {
        $pdo = null;
        $stmt = null;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method: ' . $_SERVER["REQUEST_METHOD"]]);
}
?>