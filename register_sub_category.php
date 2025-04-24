<?php
session_start();
include('db_connect.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_sub_category'])) {
    $sub_category_id = $_POST['sub_category_id'];

    if (!empty($sub_category_id)) {
        $query = "UPDATE users SET sub_category_id = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $sub_category_id, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Successfully registered for the sub-category!";
        } else {
            $_SESSION['error_message'] = "Error registering for the sub-category: " . $conn->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Please select a sub-category.";
    }
}

header('Location: user_dashboard.php');
exit();
?>
