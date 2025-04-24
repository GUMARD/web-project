<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Store credentials in session for processing
    $_SESSION['login_username'] = $username;
    $_SESSION['login_password'] = $password;

    // Redirect to login_process.php for validation
    header('Location: login_process.php');
    exit();
}
?>
