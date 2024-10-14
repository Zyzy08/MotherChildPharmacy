<?php
header('Content-Type: application/json');

// Function to log actions
function logAction($pdo, $userId, $action, $description, $status)
{
    $sql2 = "INSERT INTO audittrail (AccountID, action, description, ip_address, status) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $pdo->prepare($sql2);
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    // Execute the log action with status
    $stmt2->execute([$userId, $action, $description, $ipAddress, $status]);

    // Check for errors in execution
    if ($stmt2->errorInfo()[0] != '00000') {
        die('Error executing the statement: ' . $stmt2->errorInfo()[2]);
    }
}



session_start(); // Start session to access session variables

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $employeeName = $_POST["employeeName"];
    $employeeLName = $_POST["employeeLName"];
    $role = $_POST["role"];
    $accountName = $_POST["accountName"];
    $password = $_POST["password"];

    $SuppliersPerms = $_POST["SuppliersPerms"];
    $TransactionsPerms = $_POST["TransactionsPerms"];
    $InventoryPerms = $_POST["InventoryPerms"];
    $POSPerms = $_POST["POSPerms"];
    $REPerms = $_POST["REPerms"];
    $POPerms = $_POST["POPerms"];
    $UsersPerms = $_POST["UsersPerms"];

    $profilePicture = $_FILES["profilePicture"];

    // Process the file upload
    if ($profilePicture['error'] == 0) {
        $targetDir = "";
        $targetFile = $targetDir . basename($profilePicture["name"]);

        if (move_uploaded_file($profilePicture["tmp_name"], "uploads/" . $targetFile)) {
            try {
                require_once "databaseHandler.php";
                $sql = "INSERT INTO users (employeeName, employeeLName, role, accountName, password, picture, SuppliersPerms, TransactionsPerms, InventoryPerms, POSPerms, REPerms, POPerms, UsersPerms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$employeeName, $employeeLName, $role, $accountName, $password, $targetFile, $SuppliersPerms, $TransactionsPerms, $InventoryPerms, $POSPerms, $REPerms, $POPerms, $UsersPerms]);

                $sessionAccountID = $_SESSION['AccountID'] ?? null;
                $description = "Added user: $employeeName $employeeLName with account name $accountName.";
                // Log success
                logAction($pdo, $sessionAccountID, 'Add User', $description, 1);

                echo json_encode(['success' => true, 'message' => 'User added successfully.']);
                exit();
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => 'User was not added due to error: ' . $e->getMessage()]);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error uploading file.']);
            exit();
        }
    } else {
        try {
            require_once "databaseHandler.php";
            $sql = "INSERT INTO users (employeeName, employeeLName, role, accountName, password, SuppliersPerms, TransactionsPerms, InventoryPerms, POSPerms, REPerms, POPerms, UsersPerms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$employeeName, $employeeLName, $role, $accountName, $password, $SuppliersPerms, $TransactionsPerms, $InventoryPerms, $POSPerms, $REPerms, $POPerms, $UsersPerms]);

            $sessionAccountID = $_SESSION['AccountID'] ?? null;
            $description = "Added user: $employeeName $employeeLName with account name $accountName.";
            // Log success
            logAction($pdo, $sessionAccountID, 'Add User', $description, 1);

            echo json_encode(['success' => true, 'message' => 'User added successfully.']);
            exit();
        } catch (PDOException $e) {
            // Log failure
            $sessionAccountID = $_SESSION['AccountID'] ?? null;
            $description = "Failed to add user: $employeeName $employeeLName with account name: $accountName. Error: " . $e->getMessage();
            logAction($pdo, $sessionAccountID, 'Add User', $description, 0);

            echo json_encode(['success' => false, 'message' => 'User was not added due to error: ' . $e->getMessage()]);
            exit();
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}
?>