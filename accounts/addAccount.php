<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $role = $_POST["role"];
    $accname = $_POST["accname"];
    $pass = $_POST["pass"];
    $profilePicture = $_FILES["profilePicture"];

    if ($profilePicture['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($profilePicture["name"]);
    
        if (move_uploaded_file($profilePicture["tmp_name"], $targetFile)) {
            try {
                require_once "../databaseHandler.php";
                    $sql = "INSERT INTO accounts (employeeName, role, accountName, password, picture) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$username, $role, $accname, $pass, $targetFile]);
                    $pdo = null;
                    $statement = null;
            
                    header("Location: accounts.html");
            
                    die();
            } catch (PDOException $e) {
                die("User was not added due to error: " . $e->getMessage());
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        // echo "No file uploaded or file upload error.";
        try {
            require_once "databaseHandler.php";
                $sql = "INSERT INTO accounts (employeeName, role, accountName, password) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$username, $role, $accname, $pass]);
                $pdo = null;
                $statement = null;
        
                header("Location: accounts.html");
        
                die();
        } catch (PDOException $e) {
            die("User was not added due to error: " . $e->getMessage());
        }
    }  
}
else {
    header("Location: accounts.html");
}