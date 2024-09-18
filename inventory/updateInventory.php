<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemID = $_POST['itemID'] ?? '';

    if (empty($itemID)) {
        echo json_encode(['success' => false, 'message' => 'Missing ItemID']);
        exit;
    }

    $productCode = $_POST['ProductCode'] ?? '';
    $itemType = $_POST['itemType'] ?? '';
    $brandName = $_POST['brandName'] ?? '';
    $genericName = $_POST['genericName'] ?? '';
    $unitOfMeasure = $_POST['unitOfMeasure'] ?? '';
    $mass = $_POST['mass'] ?? '';
    $pricePerUnit = $_POST['pricePerUnit'] ?? '';
    //$InStock = $_POST['InStock'] ?? '';
    $notes = $_POST['notes'] ?? '';
    //$status = $_POST['status'] ?? '';

    // Retrieve the existing icon from the database
    $existingIconSql = "SELECT ProductIcon FROM inventory WHERE ItemID = ?";
    $stmt = $conn->prepare($existingIconSql);
    $stmt->bind_param("i", $itemID);
    $stmt->execute();
    $stmt->bind_result($existingIcon);
    $stmt->fetch();
    $stmt->close();

    $iconPath = $existingIcon; // Default to existing icon

    if (isset($_FILES['ProductIcon']) && $_FILES['ProductIcon']['error'] == UPLOAD_ERR_OK) {
        $icon = $_FILES['ProductIcon'];

        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $iconPath = $uploadDir . basename($icon['name']);
        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($icon['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
            exit;
        }

        if (move_uploaded_file($icon['tmp_name'], $iconPath)) {
            // File uploaded successfully
        } else {
            echo json_encode(['success' => false, 'message' => 'Error uploading image']);
            exit;
        }
    }

    $stmt = $conn->prepare("UPDATE inventory SET ProductCode = ?, ItemType = ?, BrandName = ?, GenericName = ?, UnitOfMeasure = ?, Mass = ?, PricePerUnit = ?, Notes = ?, ProductIcon = ? WHERE ItemID = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("ssssssissi", $productCode, $itemType, $brandName, $genericName, $unitOfMeasure, $mass, $pricePerUnit, $notes, $iconPath, $itemID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating product: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
