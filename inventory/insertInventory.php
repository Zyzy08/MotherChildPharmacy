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

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productCode = $_POST['ProductCode'] ?? '';
    $itemType = $_POST['itemType'] ?? '';
    $brandName = $_POST['brandName'] ?? '';
    $genericName = $_POST['genericName'] ?? '';
    $unitOfMeasure = $_POST['unitOfMeasure'] ?? '';
    $mass = $_POST['mass'] ?? '';
    $pricePerUnit = $_POST['pricePerUnit'] ?? '';
    $InStock = $_POST['InStock'] ?? '';
    $notes = $_POST['notes'] ?? '';
    $status = $_POST['status'] ?? '';

    // Validate required fields
    if (empty($productCode) || empty($itemType) || empty($brandName) || empty($genericName) || empty($unitOfMeasure) || empty($mass) || empty($pricePerUnit)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    // Image file handling
    $iconPath = '';
    if (isset($_FILES['ProductIcon']) && $_FILES['ProductIcon']['error'] == UPLOAD_ERR_OK) {
        $icon = $_FILES['ProductIcon'];

        // Ensure the image is uploaded to a proper directory
        $uploadDir = 'uploads/'; // Ensure this directory exists and has proper permissions
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                echo json_encode(['success' => false, 'message' => 'Failed to create upload directory']);
                exit;
            }
        }
        $iconPath = $uploadDir . basename($icon['name']);

        // Validate the file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($icon['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
            exit;
        }

        // Move uploaded file to the target directory
        if (!move_uploaded_file($icon['tmp_name'], $iconPath)) {
            echo json_encode(['success' => false, 'message' => 'Error uploading image']);
            exit;
        }
    }
    if($iconPath === "" )
    {
        $iconPath = "../resources/img/default_Icon.png";
    }



    // Prepare SQL statement to insert data
    $stmt = $conn->prepare("INSERT INTO inventory (ProductCode, ItemType, BrandName, GenericName, UnitOfMeasure, Mass, PricePerUnit, InStock, Notes, Status, ProductIcon) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    // Bind the parameters
    $stmt->bind_param("ssssssissss", $productCode, $itemType, $brandName, $genericName, $unitOfMeasure, $mass, $pricePerUnit, $InStock, $notes, $status, $iconPath);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error saving product: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
