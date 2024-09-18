<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Create an array to store form data
    $formData = [];

    // Collect all the form data
    foreach ($_POST as $key => $value) {
        $formData[$key] = $value;
    }

    // Convert form data to JSON
    $jsonData = json_encode($formData, JSON_PRETTY_PRINT);

    // Save the JSON data to a text file
    $filePath = 'formData.txt'; // Path to the text file
    file_put_contents($filePath, $jsonData);


    // Process the file upload
    if ($profilePicture['error'] == 0) {
        $targetDir = "";
        $targetFile = $targetDir . basename($profilePicture["name"]);

        if (move_uploaded_file($profilePicture["tmp_name"], to: "uploads/" . $targetFile)) {
            try {
                require_once "databaseHandler.php";
                $sql = "INSERT INTO users (employeeName, employeeLName, role, accountName, password, picture, SuppliersPerms, TransactionsPerms, InventoryPerms, POSPerms, REPerms, POPerms, UsersPerms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$employeeName, $employeeLName, $role, $accountName, $password, $targetFile, $SuppliersPerms, $TransactionsPerms, $InventoryPerms, $POSPerms, $REPerms, $POPerms, $UsersPerms]);
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
            require_once "databaseHandler.php";
            $sql = "INSERT INTO users (employeeName, employeeLName, role, accountName, password, SuppliersPerms, TransactionsPerms, InventoryPerms, POSPerms, REPerms, POPerms, UsersPerms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$employeeName, $employeeLName, $role, $accountName, $password, $SuppliersPerms, $TransactionsPerms, $InventoryPerms, $POSPerms, $REPerms, $POPerms, $UsersPerms]);
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