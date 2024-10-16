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
function logAction($conn, $userId, $action, $description, $Status)
{
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $logSql = "INSERT INTO audittrail (AccountID, action, description, ip_address, Status) VALUES (?, ?, ?, ?, ?)";
    $logStmt = $conn->prepare($logSql);
    $logStmt->bind_param("ssssi", $userId, $action, $description, $ipAddress, $Status);
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

$sql2 = $conn->prepare("SELECT AccountID FROM users WHERE accountName = ?");
$sql2->bind_param("s", $inputUsername);
$sql2->execute();
$result2 = $sql2->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($user) {
        // Password matches, proceed to login
        $_SESSION['AccountID'] = $user['AccountID']; // Store AccountID in session

        // Log the successful login action
        logAction($conn, $_SESSION['AccountID'], 'Login', 'User logged in successfully.', 1);

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
} else if ($result2->num_rows > 0) {
    $user2 = $result2->fetch_assoc();
    if ($user2) {
        logAction($conn, $user2['AccountID'], 'Login', 'User failed to login (Incorrect password).', 0);
        $error = "Incorrect password.";
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