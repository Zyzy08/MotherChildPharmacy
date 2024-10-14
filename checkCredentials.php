<?php
session_start(); // Start the session to use session variables

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "motherchildpharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to log actions
function logAction($conn, $userId, $action, $description)
{
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $logSql = "INSERT INTO audittrail (AccountID, action, description, ip_address) VALUES (?, ?, ?, ?)";
    $logStmt = $conn->prepare($logSql);
    $logStmt->bind_param("ssss", $userId, $action, $description, $ipAddress);
    $logStmt->execute();
    $logStmt->close();
}


// Initialize error variable
$error = "";

// Retrieve user input from POST request
$inputUsername = $_POST['username'];
$inputPassword = $_POST['password'];

// Prepare the SQL statement to fetch AccountID and other necessary columns
$sql = $conn->prepare("SELECT AccountID FROM users WHERE accountName = ? AND password = ?");
$sql->bind_param("ss", $inputUsername, $inputPassword);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($user) {
        // Password matches, proceed to login
        $_SESSION['AccountID'] = $user['AccountID']; // Store AccountID in session

        // Log the successful login action
        logAction($conn, $_SESSION['AccountID'], 'Login', 'User logged in successfully.');

        // Set Status to Online
        $updateSql = "UPDATE users SET connected = 1 WHERE AccountID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $_SESSION['AccountID']);
        $updateStmt->execute();

        header("Location: dashboard/dashboard.php");
        exit();
    } else {
        $error = "Invalid password.";
    }
} else {
    $error = "Invalid username or password.";
}

// Set error message in session with a unique error ID
$_SESSION['login_error'] = $error;
$_SESSION['login_error_id'] = uniqid(); // Generate a unique ID for the error message

// Close the connection
$conn->close();

// Redirect back to login page
header("Location: index.php");
exit();
?>