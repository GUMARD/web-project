<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $phone_no = $_POST['Phone_no'];

    // Check if the username already exists in the database
    $check_username_query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($check_username_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose a different username.'); window.history.back();</script>";
    } else {
        // Check for matching passwords
        if ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match');</script>";
        } else {
            // Insert user into the database
            $insert_query = "INSERT INTO users (username, password, email, phone_no) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ssss", $username, $password, $email, $phone_no);

            if ($stmt->execute()) {
                // Store user ID in session
                $_SESSION['user_id'] = $stmt->insert_id;
                echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('Error in inserting data: " . $stmt->error . "');</script>";
            }
        }
    }
    $stmt->close();
    $conn->close();
}
?>
