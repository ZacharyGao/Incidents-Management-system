<?php
// Example of a simple login script (login.php)

// Start the session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Add database connection code here
    // ...

    // Query the database to check if the username and password are correct
    // ...

    if ($login_successful) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        // Redirect to the home page or dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        $error_message = "Invalid Username or Password";
    }
}

// Close the database connection
?>
something
