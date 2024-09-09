<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mother & Child Pharmacy & Medical Supplies</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100..900&display=swap" rel="stylesheet">
    <script src="client.js" defer></script>
</head>
<body class="page">
    <div class="container">
        <img src="resources/mnc_logo.png" alt="Logo" class="logo">
        <h1 class="main-text">Mother & Child</h1>
        <h1 class="sub-text">Pharmacy & Medical Supplies</h1>
        <div class="login-container">
            <h2 class="login-text">Login</h2>            
            <form action="checkCredentials.php" method="POST">
                <div class="textbox username-box">
                    <label for="username" class="label">Username</label>
                    <div class="input-container">
                        <img src="resources/mail.png" alt="Mail Icon" class="mail-icon">
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                </div>
                <div class="textbox password-box">
                    <label for="password" class="label">Password</label>
                    <div class="input-container">
                        <img src="resources/lock.png" alt="Lock Icon" class="lock-icon">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <img src="resources/hide.png" id="hide-icon" alt="Hide Icon" class="hide-icon" onclick="togglePasswordVisibility()">
                    </div>
                </div>
                <button type="submit" class="button">Sign in</button>
            </form>
            <?php
            session_start();
            if (isset($_SESSION['login_error']) && $_SESSION['login_error'] !== "") {
                $error_id = $_SESSION['login_error_id'];
                echo '<p id="error-' . $error_id . '" class="error-message">' . $_SESSION['login_error'] . '</p>';
                unset($_SESSION['login_error']);
                unset($_SESSION['login_error_id']);
            }
            ?>
        </div>
        <img src="resources/right_dec.png" alt="Right Decoration" class="right-dec">
        <img src="resources/left_dec.png" alt="Left Decoration" class="left-dec">
    </div>
    <script>
    function hideErrorMessage() {
        document.querySelectorAll('[id^="error-"]').forEach((element) => {
            setTimeout(() => {
                element.style.display = 'none';
            }, 2000);
        });
    }

    // Call the function when the page loads
    window.onload = hideErrorMessage;
    </script>
</body>
</html>
