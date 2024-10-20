<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the supplier ID
    $supplierID = $_POST["supplierID"];
    $companyName = $_POST["companyName"];
    $agentName = $_POST["agentName"];
    $ContactNo = $_POST["ContactNo"];
    $Email = $_POST["Email"];
    $Notes = $_POST["Notes"];

    try {
        require_once "../users/databaseHandler.php";

        // Prepare the SQL UPDATE statement
        $sql = "UPDATE suppliers SET SupplierName = ?, AgentName = ?, Phone = ?, Email = ?, Notes = ? WHERE SupplierID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$companyName, $agentName, $ContactNo, $Email, $Notes, $supplierID]);

        echo json_encode(['success' => true, 'message' => 'Data updated successfully.']);
        exit();
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Data was not updated due to error: ' . $e->getMessage()]);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}
?>