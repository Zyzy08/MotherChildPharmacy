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
    $productCode = $conn->real_escape_string($_POST['ProductCode'] ?? '');
    $itemType = $conn->real_escape_string($_POST['itemType'] ?? '');
    $brandName = $conn->real_escape_string($_POST['brandName'] ?? '');
    $genericName = $conn->real_escape_string($_POST['genericName'] ?? '');
    $unitOfMeasure = $conn->real_escape_string($_POST['unitOfMeasure'] ?? '');
    $mass = $conn->real_escape_string($_POST['mass'] ?? '');
    $pricePerUnit = $conn->real_escape_string($_POST['pricePerUnit'] ?? '');
    $Discount = $conn->real_escape_string($_POST['Discount'] ?? ''); // Keep as string for validation
    $InStock = $conn->real_escape_string($_POST['InStock'] ?? ''); // Initialize InStock
    $notes = $conn->real_escape_string($_POST['notes'] ?? '');
    $VAT_exempted = $conn->real_escape_string($_POST['VAT_exempted'] ?? ''); // New field for VAT exemption

    // Validate required fields (excluding InStock)
    if (empty($productCode) || empty($itemType) || empty($brandName) || empty($genericName) || empty($unitOfMeasure) || empty($mass) || empty($pricePerUnit) || $Discount === '') {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    // Validate numeric fields
    if (!is_numeric($mass) || !is_numeric($pricePerUnit)) {
        echo json_encode(['success' => false, 'message' => 'Mass and PricePerUnit must be numeric']);
        exit;
    }

    // Set InStock to 0 if empty (default value)
    if (empty($InStock)) {
        $InStock = 0; // Default value if InStock is not provided
    } elseif (!is_numeric($InStock)) {
        echo json_encode(['success' => false, 'message' => 'InStock must be numeric']);
        exit;
    }

    // Image file handling
    $iconPath = '';
    if (isset($_FILES['ProductIcon']) && $_FILES['ProductIcon']['error'] == UPLOAD_ERR_OK) {
        $icon = $_FILES['ProductIcon'];

        // Ensure the image is uploaded to a proper directory
        $uploadDir = 'products-icon/'; // Ensure this directory exists and has proper permissions
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

    // Set default icon if none was uploaded
    if (empty($iconPath)) {
        $iconPath = "../resources/img/default_Icon.png";
    }

    // Calculate ReorderLevel as 50% of InStock
    $ReorderLevel = $InStock * 0.5;

    // Prepare SQL statement to insert data, including the VAT_exempted field
    $stmt = $conn->prepare("INSERT INTO inventory (ProductCode, ItemType, BrandName, GenericName, UnitOfMeasure, Mass, PricePerUnit, Discount, InStock, Notes, ReorderLevel, ProductIcon, VAT_exempted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    // Bind the parameters, including VAT_exempted
    $stmt->bind_param("ssssssiisssss", $productCode, $itemType, $brandName, $genericName, $unitOfMeasure, $mass, $pricePerUnit, $Discount, $InStock, $notes, $ReorderLevel, $iconPath, $VAT_exempted);

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
