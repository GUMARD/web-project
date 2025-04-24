<?php
session_start();
include('db_connect.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];

    if (!empty($name) && !empty($email) && !empty($phone_no)) {
        $query = "UPDATE users SET username = ?, email = ?, phone_no = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $name, $email, $phone_no, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Profile updated successfully!";
        } else {
            $_SESSION['error_message'] = "Error updating profile: " . $conn->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Please fill in all fields.";
    }
}

header('Location: user_dashboard.php');
exit();
?>
