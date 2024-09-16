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
