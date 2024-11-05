<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error); // Log connection error
    die("Connection failed: " . $conn->connect_error);
}

// Check if itemID is set in the request
if (isset($_GET['itemID'])) {
    $itemID = intval($_GET['itemID']);
    $sql = "SELECT inventory.InStock, inventory.Ordered, delivery_items.QuantityRemaining 
    FROM inventory 
    LEFT JOIN delivery_items ON inventory.ItemID = delivery_items.ItemID 
    WHERE inventory.ItemID = ? AND inventory.Status = 'Active'";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("SQL Error: " . $conn->error); // Log SQL error
        echo json_encode(['error' => 'Database error occurred.']);
        exit;
    }
    $stmt->bind_param("i", $itemID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $productData = $result->fetch_assoc();
        echo json_encode($productData);
    } else {
        echo json_encode(null);
    }
} elseif (isset($_GET['query'])) {
    $query = $_GET['query'];
    $sql = "SELECT ItemID, GenericName, BrandName, Mass, UnitOfMeasure, InStock, Ordered 
            FROM inventory 
            WHERE (GenericName LIKE ? OR BrandName LIKE ?) AND Status = 'Active' LIMIT 10";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("SQL Error: " . $conn->error); // Log SQL error
        echo json_encode(['error' => 'Database error occurred.']);
        exit;
    }
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode($products);
} elseif (isset($_GET['lotQuery'])) {
    $lotQuery = $_GET['lotQuery'];
    $sql = "SELECT LotNumber, QuantityRemaining FROM delivery_items WHERE LotNumber LIKE ? LIMIT 10";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("SQL Error: " . $conn->error); // Log SQL error
        echo json_encode(['error' => 'Database error occurred.']);
        exit;
    }
    $searchTerm = "%" . $lotQuery . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $lots = [];
    while ($row = $result->fetch_assoc()) {
        $lots[] = $row;
    }
    echo json_encode($lots);
} elseif (isset($_GET['lotNumber'])) {
    $lotNumber = $_GET['lotNumber'];
    $sql = "SELECT QuantityRemaining FROM delivery_items WHERE LotNumber = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("SQL Error: " . $conn->error); // Log SQL error
        echo json_encode(['error' => 'Database error occurred.']);
        exit;
    }
    $stmt->bind_param("s", $lotNumber); // Assuming LotNumber is a string
    $stmt->execute();
    $stmt->bind_result($quantityRemaining);
    $stmt->fetch();

    // Check if quantityRemaining is null or an empty string
    if ($quantityRemaining !== null && $quantityRemaining !== '') {
        echo json_encode(['QuantityRemaining' => $quantityRemaining]); // Return as JSON
    } else {
        echo json_encode(['message' => "Lot number not found."]); // Handle not found case
    }
    $stmt->close();
}

$stmt->close();
$conn->close();
?>
