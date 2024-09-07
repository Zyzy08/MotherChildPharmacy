<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeName = $_POST["employeeName"];
    $role = $_POST["role"];
    $accountName = $_POST["accountName"];
    $password = $_POST["password"];
    $profilePicture = $_FILES["profilePicture"];
    $status = $_POST["status"];

    // Process the file upload
    if ($profilePicture['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($profilePicture["name"]);
    
        if (move_uploaded_file($profilePicture["tmp_name"], $targetFile)) {
            try {
                require_once "../databaseHandler.php";
                $sql = "INSERT INTO accounts (employeeName, role, accountName, password, picture, status) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$employeeName, $role, $accountName, $password, $targetFile, $status]);
                $pdo = null;
                $stmt = null;
                
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
            require_once "../databaseHandler.php";
            $sql = "INSERT INTO accounts (employeeName, role, accountName, password, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$employeeName, $role, $accountName, $password, $status]);
            $pdo = null;
            $stmt = null;
            
            echo json_encode(['success' => true, 'message' => 'User added successfully.']);
            exit();
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'User was not added due to error: ' . $e->getMessage()]);
            exit();
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}
?>