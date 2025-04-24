<?php
session_start();
include('db_connect.php');

// Ensure admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    $dance_type = trim($_POST['dance_type']);
  
    if (!empty($category_name) && !empty($dance_type)) {
        $query = "INSERT INTO dance_categories (category_name, dance_type) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param('ss', $category_name, $dance_type);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Dance category added successfully!";
            } else {
                $_SESSION['error_message'] = "Error adding category: " . $stmt->error;
            }
            $stmt->close(); 
        } else {
            $_SESSION['error_message'] = "Error preparing statement: " . $conn->error;
        }
    } else {
        $_SESSION['error_message'] = "Please fill in all fields.";
    }
    header('Location: admin_dashboard.php');
    exit();
}
?>
