<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Get the current user's AccountID from the session or other source
session_start();
$sessionAccountID = $_SESSION['AccountID'] ?? null;

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);

function logAction($conn, $userId, $action, $description, $status)
{
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $logSql = "INSERT INTO audittrail (AccountID, action, description, ip_address, status) VALUES (?, ?, ?, ?, ?)";
    $logStmt = $conn->prepare($logSql);
    $logStmt->bind_param("ssssi", $userId, $action, $description, $ipAddress, $status);
    $logStmt->execute();
    $logStmt->close();
}

// Check database connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemID = $_POST['itemID'] ?? '';

    // Check for missing ItemID
    if (empty($itemID)) {
        echo json_encode(['success' => false, 'message' => 'Missing ItemID']);
        exit;
    }

    // Retrieve form data
    $productCode = $_POST['ProductCode'] ?? '';
    $itemType = $_POST['itemType'] ?? '';
    $brandName = $_POST['brandName'] ?? '';
    $genericName = $_POST['genericName'] ?? '';
    $unitOfMeasure = $_POST['unitOfMeasure'] ?? '';
    $mass = $_POST['mass'] ?? '';
    $pricePerUnit = $_POST['pricePerUnit'] ?? '';
    $InStock = $_POST['InStock'] ?? '';
    $Discount = $_POST['Discount'] ?? '';

    // Retrieve the VAT exempted status, defaulting to 0 (not exempted)
    $VAT_Exempted = isset($_POST['VAT_Exempted']) ? 1 : 0;

    // Retrieve the existing icon from the database
    $existingIconSql = "SELECT ProductIcon FROM inventory WHERE ItemID = ?";
    $stmt = $conn->prepare($existingIconSql);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("i", $itemID);
    $stmt->execute();
    $stmt->bind_result($existingIcon);
    $stmt->fetch();
    $stmt->close();

    $iconPath = $existingIcon; // Default to existing icon

    // Handle the icon upload
    if (isset($_FILES['ProductIcon']) && $_FILES['ProductIcon']['error'] == UPLOAD_ERR_OK) {
        $icon = $_FILES['ProductIcon'];

        $uploadDir = 'products-icon/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create directory if it doesn't exist
        }

        $iconPath = $uploadDir . basename($icon['name']);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        // Check for valid file type
        if (!in_array($icon['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
            exit;
        }

        // Attempt to move the uploaded file
        if (!move_uploaded_file($icon['tmp_name'], $iconPath)) {
            echo json_encode(['success' => false, 'message' => 'Error uploading image']);
            exit;
        }
    }

    // Update the product details including VAT_Exempted
    $stmt = $conn->prepare("UPDATE inventory SET ProductCode = ?, ItemType = ?, BrandName = ?, GenericName = ?, UnitOfMeasure = ?, Mass = ?, PricePerUnit = ?, Discount = ?, ProductIcon = ?, VAT_Exempted = ? WHERE ItemID = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    // Bind parameters and execute the update statement
    $stmt->bind_param("sssssiissii", $productCode, $itemType, $brandName, $genericName, $unitOfMeasure, $mass, $pricePerUnit, $Discount, $iconPath, $VAT_Exempted, $itemID);

    $updatedetails = "(ItemID: " . $itemID . ")";

    // Execute the query and handle the response
    if ($stmt->execute()) {
        //Log if Success
        $description = "User updated the details of a product. $updatedetails.";
        logAction($conn, $sessionAccountID, 'Product Update', $description, 1);
        echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
    } else {
        //Log if Fail
        $description = "User failed to update the details of a product. $updatedetails.";
        logAction($conn, $sessionAccountID, 'Product Update', $description, 0);
        echo json_encode(['success' => false, 'message' => 'Error updating product: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>