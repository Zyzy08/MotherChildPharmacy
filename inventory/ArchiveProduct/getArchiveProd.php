<?php
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost';
$db = 'motherchildpharmacy';
$user = 'root';
$password = '';

try {
    // Create a new mysqli instance
    $conn = new mysqli($host, $user, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }

    // Check if we received a request to archive a product
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['itemID'])) {
        $itemID = $conn->real_escape_string($input['itemID']);

        // Prepare the SQL statement to update the status of the product to 'Inactive'
        $sql = "UPDATE inventory SET Status = 'Inactive' WHERE ItemID = '$itemID'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Product archived successfully.']);
        } else {
            throw new Exception('Failed to archive product: ' . $conn->error);
        }
    } else {
        // Prepare the SQL statement to fetch inactive inventory items
        $sql = "SELECT ItemID, GenericName, BrandName, ItemType, Mass, UnitOfMeasure, InStock, Ordered, ReorderLevel, PricePerUnit, SupplierID, Notes, ProductIcon, ProductCode, Discount 
                FROM inventory 
                WHERE Status = 'Inactive'";
        $result = $conn->query($sql);

        // Initialize the data array
        $data = [];

        if ($result) {
            // Fetch results if available
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                echo json_encode(['success' => true, 'data' => $data]);
            } else {
                // Return a valid response with no products
                echo json_encode(['success' => true, 'data' => [], 'message' => 'No inactive products found.']);
            }
        } else {
            throw new Exception('Query failed: ' . $conn->error);
        }
    }
} catch (Exception $e) {
    // Log the error message for debugging (optional: store in a file)
    error_log($e->getMessage());

    // Return a generic error message for the user
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing the request.']);
} finally {
    // Close the database connection
    if (isset($conn)) {
        $conn->close();
    }
}
?>