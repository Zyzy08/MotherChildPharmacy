<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyName = $_POST["companyName"];
    $agentName = $_POST["agentName"];
    $ContactNo = $_POST["ContactNo"];
    $Email = $_POST["Email"];
    $Notes = $_POST["Notes"];


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

    try {
        require_once "../users/databaseHandler.php";
        $sql = "INSERT INTO suppliers (SupplierName, AgentName, Phone, Email, Notes) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$companyName, $agentName, $ContactNo, $Email, $Notes]);
        $pdo = null;
        $stmt = null;

        echo json_encode(['success' => true, 'message' => 'Data added successfully.']);
        exit();
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Data was not added due to error: ' . $e->getMessage()]);
        exit();
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}
?>