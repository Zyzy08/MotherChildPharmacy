<?php
header('Content-Type: application/json');

// $logFile = 'debug.log';
// error_log("Received POST data: " . json_encode($_POST), 3, $logFile);
// error_log("Received FILES data: " . json_encode($_FILES), 3, $logFile);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $employeeName = $_POST["employeeNameEdit"];
    $employeeLName = $_POST["employeeLNameEdit"];
    $role = $_POST["roleEdit"];
    $accountName = $_POST["accountNameEdit"];
    $password = $_POST["passwordEdit"];
    $AccountID = $_POST["AccountID"];

    $SuppliersPerms = $_POST["SuppliersPermsEdit"];
    $TransactionsPerms = $_POST["TransactionsPermsEdit"];
    $InventoryPerms = $_POST["InventoryPermsEdit"];
    $POSPerms = $_POST["POSPermsEdit"];
    $REPerms = $_POST["REPermsEdit"];
    $POPerms = $_POST["POPermsEdit"];
    $UsersPerms = $_POST["UsersPermsEdit"];
    
    // Check if a new profile picture was uploaded
    $profilePicture = $_FILES["profilePictureEdit"] ?? null;
    $picturePath = null;
    
    // Process the file upload if a new profile picture is provided
    if ($profilePicture && $profilePicture['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($profilePicture["name"]);
    
        if (move_uploaded_file($profilePicture["tmp_name"], $targetFile)) {
            $picturePath = $targetFile;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error uploading file.']);
            exit();
        }
    }
    
    try {
        require_once "databaseHandler.php";
        
        // Prepare the SQL query
        if ($picturePath) {
            $sql = "UPDATE users SET employeeName = ?, employeeLName = ?, role = ?, accountName = ?, password = ?, picture = ?, SuppliersPerms = ?, TransactionsPerms = ?, InventoryPerms = ?, POSPerms = ?, REPerms = ?, POPerms = ?, UsersPerms = ? WHERE AccountID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$employeeName, $employeeLName, $role, $accountName, $password, $picturePath, $SuppliersPerms, $TransactionsPerms, $InventoryPerms, $POSPerms, $REPerms, $POPerms, $UsersPerms, $AccountID]);
        } else {
            $sql = "UPDATE users SET employeeName = ?, employeeLName = ?, role = ?, accountName = ?, password = ?, SuppliersPerms = ?, TransactionsPerms = ?, InventoryPerms = ?, POSPerms = ?, REPerms = ?, POPerms = ?, UsersPerms = ? WHERE AccountID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$employeeName, $employeeLName, $role, $accountName, $password, $SuppliersPerms, $TransactionsPerms, $InventoryPerms, $POSPerms, $REPerms, $POPerms, $UsersPerms, $AccountID]);
        }
        
        $pdo = null;
        $stmt = null;

        echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
        exit();
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'User was not updated due to error: ' . $e->getMessage()]);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}
?>
