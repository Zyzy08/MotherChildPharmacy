<?php
header('Content-Type: application/json');

try {
    // Get the receipt content and order number
    $content = $_POST['content'];
    $orderNum = $_POST['orderNum'];
    
    // Create a temporary file name
    $filename = "receipt_" . $orderNum . ".txt";
    $filepath = "..\\transactions\\receipt-history\\" . $filename; 
    
    // Save the content to the file
    file_put_contents($filepath, $content);
    
    // Print the file using notepad
    $command = "notepad /p " . escapeshellarg($filepath);
    exec($command, $output, $return);
    
    // Check if printing was successful
    if ($return === 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Receipt printed successfully'
        ]);
    } else {
        throw new Exception('Failed to print receipt');
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
