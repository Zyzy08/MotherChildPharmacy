<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['description'])) {
    $description = $_GET['description'];

    try {
        require_once "../users/databaseHandler.php"; // Make sure to include your database connection
        $sql = "SELECT itemID FROM inventory WHERE CONCAT(BrandName, ' ', GenericName, ' (', Mass, ' ', UnitOfMeasure, ')') = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$description]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            echo json_encode(['success' => true, 'itemID' => $item['itemID']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Item not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
