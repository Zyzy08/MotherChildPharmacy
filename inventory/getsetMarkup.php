<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'motherchildpharmacy';
$conn = new mysqli($host, $user, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    $response = [
        'status' => 'error',
        'message' => 'Database connection failed: ' . $conn->connect_error
    ];
    sendResponse($response);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle fetching current markup
    $itemID = $_GET['itemID'];
    $stmt = $conn->prepare("SELECT Markup FROM inventory LIMIT 1");
    $stmt->execute();
    $stmt->bind_result($markup);
    $stmt->fetch();

    if ($stmt->errno) {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    } else {
        echo json_encode(['status' => 'success', 'markup' => $markup]);
    }
    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle updating the markup
    $input = json_decode(file_get_contents("php://input"), true);
    $itemID = $input['itemID'];
    $newMarkup = $input['markup'];
    $oldMarkup = $input['oldmarkup'];

    if ($newMarkup >= 0.01 && $newMarkup <= 1.00) { // Ensure markup is between 1% and 100%
        $stmt = $conn->prepare("UPDATE inventory SET Markup = ?, PricePerUnit = ROUND((PricePerUnit / ((100 + ?) / 100)) * (1 + ?), 2)");
        //(PricePerUnit / ((100 + $oldMarkup) / 100)) * (1 + $newMarkup)
        $stmt->bind_param("ddd", $newMarkup, $oldMarkup, $newMarkup);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid markup value.']);
    }
}

$conn->close();
?>