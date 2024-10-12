<?php
header('Content-Type: application/json');
session_start(); // Start the session

// $logFile = 'debug.log';
// error_log("Received POST data: " . json_encode($_POST), 3, $logFile);
// error_log("Received FILES data: " . json_encode($_FILES), 3, $logFile);

function logAction($pdo, $userId, $action, $description) {
    // Prepare and bind
    $sql2 = "INSERT INTO audittrail (AccountID, action, description, ip_address) VALUES (?, ?, ?, ?)";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([$userId, $action, $description, $_SERVER['REMOTE_ADDR']]);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $employeeName = $_POST["employeeNameEdit"];
    $employeeLName = $_POST["employeeLNameEdit"];
    $role = $_POST["roleEdit"];
    $accountName = $_POST["accountNameEdit"];
    $password = $_POST["passwordEdit"];
    $AccountID = $_POST["AccountID"];
    $loggedUserID = $_SESSION['AccountID'];

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
        $targetDir = "";
        $targetFile = $targetDir . basename($profilePicture["name"]);
    
        if (move_uploaded_file($profilePicture["tmp_name"], to: "uploads/" . $targetFile)) {
            $picturePath = $targetFile;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error uploading file.']);
            exit();
        }
    }
    
    try {
        require_once "databaseHandler.php";

        $newData = "Name: $employeeName, Last Name: $employeeLName, Role: $role, Account Name: $accountName";
        
        // Prepare the SQL query
        if ($picturePath) {
            $newData .= ", Profile Picture: $picturePath";
            $sql = "UPDATE users SET employeeName = ?, employeeLName = ?, role = ?, accountName = ?, password = ?, picture = ?, SuppliersPerms = ?, TransactionsPerms = ?, InventoryPerms = ?, POSPerms = ?, REPerms = ?, POPerms = ?, UsersPerms = ? WHERE AccountID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$employeeName, $employeeLName, $role, $accountName, $password, $picturePath, $SuppliersPerms, $TransactionsPerms, $InventoryPerms, $POSPerms, $REPerms, $POPerms, $UsersPerms, $AccountID]);
        } else {
            $sql = "UPDATE users SET employeeName = ?, employeeLName = ?, role = ?, accountName = ?, password = ?, SuppliersPerms = ?, TransactionsPerms = ?, InventoryPerms = ?, POSPerms = ?, REPerms = ?, POPerms = ?, UsersPerms = ? WHERE AccountID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$employeeName, $employeeLName, $role, $accountName, $password, $SuppliersPerms, $TransactionsPerms, $InventoryPerms, $POSPerms, $REPerms, $POPerms, $UsersPerms, $AccountID]);
        }
                
        $stmt = null;

        logAction($pdo, $loggedUserID, 'Profile Update', "User updated a profile with new data: $newData");
        $pdo = null;
        
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
