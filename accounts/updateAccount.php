<?php
header('Content-Type: application/json');

// $logFile = 'debug.log';
// error_log("Received POST data: " . json_encode($_POST), 3, $logFile);
// error_log("Received FILES data: " . json_encode($_FILES), 3, $logFile);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $employeeName = $_POST["employeeNameEdit"];
    $role = $_POST["roleEdit"];
    $accountName = $_POST["accountNameEdit"];
    $password = $_POST["passwordEdit"];
    $status = $_POST["statusEdit"];
    $AccountID = $_POST["AccountID"];
    
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
        require_once "../databaseHandler.php";
        
        // Prepare the SQL query
        if ($picturePath) {
            $sql = "UPDATE accounts SET employeeName = ?, role = ?, accountName = ?, password = ?, picture = ?, status = ? WHERE AccountID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$employeeName, $role, $accountName, $password, $picturePath, $status, $AccountID]);
        } else {
            $sql = "UPDATE accounts SET employeeName = ?, role = ?, accountName = ?, password = ?, status = ? WHERE AccountID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$employeeName, $role, $accountName, $password, $status, $AccountID]);
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
