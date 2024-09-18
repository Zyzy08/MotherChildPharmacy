<?php
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost';  // Update with your database host
$db = 'motherchildpharmacy';  // Update with your database name
$user = 'root';  // Update with your database username
$password = '';  // Update with your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if an ItemID is provided
    if (isset($_GET['itemID'])) {
        $itemID = $_GET['itemID']; // Get the itemID from query parameters

        // Validate that itemID is numeric
        if (!is_numeric($itemID)) {
            echo json_encode(['success' => false, 'message' => 'Invalid ItemID.']);
            exit;
        }

        // Sanitize input
        $itemID = htmlspecialchars($itemID);

        // Fetch details for the specific ItemID
        $sql = "SELECT * FROM inventory WHERE ItemID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$itemID]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Item not found.']);
        }
    } else {
        // Fetch all items if no ItemID is provided
        $sql = "SELECT * FROM inventory";
        $stmt = $pdo->query($sql);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} finally {
    // Close the database connection
    $pdo = null;
    $stmt = null;
}
?>
