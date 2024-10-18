<?php
// Database connection settings
$host = 'localhost';
$db = 'motherchildpharmacy';
$user = 'root';
$password = '';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the supplierID from the query string
    if (isset($_GET['supplierID'])) {
        $supplierID = $_GET['supplierID'];

        // Prepare the SQL statement
        $sql = "SELECT * FROM suppliers WHERE SupplierID = :supplierID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':supplierID', $supplierID);
        $stmt->execute();

        // Fetch the supplier data
        $supplier = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($supplier) {
            echo json_encode(['success' => true, 'supplier' => $supplier]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Supplier not found.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Supplier ID is missing.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
