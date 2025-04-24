<?php
session_start();
require_once 'db_connect.php';

// Check if credentials are set
if (!isset($_SESSION['login_username'], $_SESSION['login_password'])) {
    header('Location: login.php');
    exit();
}

// Retrieve credentials
$username = $_SESSION['login_username'];
$password = $_SESSION['login_password'];

// Query database for the user
$stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Compare the plain-text password
    if ($password === $user['password']) {
        // Login successful, set session variables
        $_SESSION['user_id'] = $user['id']; // Ensure user ID is stored in session
        $_SESSION['role'] = $user['role'];
        $_SESSION['login_from_login_php'] = true;

        // Redirect based on user role
        if ($user['role'] === 'admin') {
            header('Location: admin_dashboard.php');
        } else {
            header('Location: user_dashboard.php');
        }
        exit();
    } else {
        $error = "Invalid username or password.";
    }
} else {
    $error = "Invalid username or password.";
}

// If login fails, redirect back to login.php with an error message
$_SESSION['login_error'] = $error;
header('Location: login.php');
exit();
?>
