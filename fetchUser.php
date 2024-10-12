<?php
session_start(); // Start the session

// Check if the user is logged in by checking for AccountID in the session
if (!isset($_SESSION['AccountID'])) {
    // Redirect to login page if not logged in
    header("Location: ../index.php");
    exit();
}

// Get the AccountID from the session
$accountID = $_SESSION['AccountID'];

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

// Prepare the SQL statement to fetch employeeName, role, and picture
$sql = $conn->prepare("SELECT * FROM users WHERE AccountID = ?");
$sql->bind_param("i", $accountID);
$sql->execute();
$result = $sql->get_result();

// Fetch the employeeName, role, and picture
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $AccountID = $user['AccountID'];
    $employeeName = $user['employeeName'];
    $employeeLName = $user['employeeLName'];
    $role = $user['role'];
    $accountName = $user['accountName'];
    $password = $user['password'];
    $picture = $user['picture'];
    $dateCreated = $user['dateCreated'];
    $status = $user['status'];
    $employeeFullName = $employeeName . " " . $employeeLName;
    $SuppliersPerms = $user['SuppliersPerms'];
    $TransactionsPerms = $user['TransactionsPerms'];
    $InventoryPerms = $user['InventoryPerms'];
    $POSPerms = $user['POSPerms'];
    $REPerms = $user['REPerms'];
    $POPerms = $user['POPerms'];
    $UsersPerms = $user['UsersPerms'];

    // Store permissions in the session
    $_SESSION['SuppliersPerms'] = $SuppliersPerms;
    $_SESSION['TransactionsPerms'] = $TransactionsPerms;
    $_SESSION['InventoryPerms'] = $InventoryPerms;
    $_SESSION['POSPerms'] = $POSPerms;
    $_SESSION['REPerms'] = $REPerms;
    $_SESSION['POPerms'] = $POPerms;
    $_SESSION['UsersPerms'] = $UsersPerms;


    // Split the employeeName into words
    $nameParts = explode(' ', $employeeFullName);

    // Get the first letter of the first name
    $initials = strtoupper($nameParts[0][0]);

    // Loop through the middle names to get their first letters (if any)
    for ($i = 1; $i < count($nameParts) - 1; $i++) {
        $initials .= strtoupper($nameParts[$i][0]); // Add the first letter of each middle name
    }

    // Add the last name
    $formattedName = $initials . '.' . end($nameParts);

    // Format the dateCreated field as "Month Day, Year"
    $dateCreatedFormatted = (new DateTime($dateCreated))->format('F j, Y');
} else {
    // Default values in case no data is found
    $formattedName = "Unknown";
    $role = "Unknown";
    $picture = "resources/img/profile_icon.png"; // Default profile picture
}

// Close the connection
$conn->close();
?>