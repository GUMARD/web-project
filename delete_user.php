<?php
session_start();
include('db_connect.php');

// Ensure admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = intval($_POST['user_id']);
    if ($user_id > 0) {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param('i', $user_id);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "User deleted successfully!";
            } else {
                $_SESSION['error_message'] = "Error deleting user: " . $stmt->error;
            }
            $stmt->close(); 
        } else {
            $_SESSION['error_message'] = "Error preparing statement: " . $conn->error;
        }
    } else {
        $_SESSION['error_message'] = "Invalid user ID.";
    }
    header('Location: admin_dashboard.php');
    exit();
}
?>
