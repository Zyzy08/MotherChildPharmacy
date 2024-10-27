<?php
// Database connection settings
$host = 'localhost';
$db = 'motherchildpharmacy';
$user = 'root';
$password = '';

header('Content-Type: application/json'); // Set the content type for JSON response

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the supplierID from the query string
    if (isset($_GET['supplierID']) && is_numeric($_GET['supplierID'])) {
        $supplierID = (int) $_GET['supplierID']; // Cast to integer for safety
        
        // Log the SupplierID being fetched
        error_log('Fetching supplier data for SupplierID: ' . $supplierID);

        // Prepare the SQL statement
        $sql = "SELECT * FROM suppliers WHERE SupplierID = :supplierID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':supplierID', $supplierID, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the supplier data
        $supplier = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($supplier) {
            echo json_encode(['success' => true, 'supplier' => $supplier]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Supplier not found.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid or missing Supplier ID.']);
    }
} catch (PDOException $e) {
    // Log the database error
    error_log('Database error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Log any other errors
    error_log('Error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}
?>
