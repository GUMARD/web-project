<?php
session_start();
include('db_connect.php');

// Ensure admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_user'])) {
    $search_term = trim($_POST['search_term']);
    $search_results = [];
    if (!empty($search_term)) {
        $query = "SELECT u.id, u.username, u.email, u.phone_no, 
                  COALESCE(d.category_name, 'Not Assigned') AS category_name 
                  FROM users u 
                  LEFT JOIN dance_categories d ON u.sub_category_id = d.id 
                  WHERE u.username LIKE ?";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $like_term = '%' . $search_term . '%';
            $stmt->bind_param('s', $like_term);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $search_results[] = $row;
                }
            } else {
                $_SESSION['error_message'] = "No users found for the search term.";
            }
            $stmt->close();
        } else {
            $_SESSION['error_message'] = "Error preparing statement: " . $conn->error;
        }
    } else {
        $_SESSION['error_message'] = "Search term cannot be empty.";
    }
    $_SESSION['search_results'] = $search_results;
    header('Location: admin_dashboard.php');
    exit();
}
?>
