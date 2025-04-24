<?php
session_start();
include('db_connect.php');

// Ensure the user is logged in
if (!isset($_SESSION['role'], $_SESSION['login_from_login_php']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit();
}

// Check if user_id is set in the session
if (isset($_SESSION['user_id'])) { // Corrected session variable name
    $user_id = $_SESSION['user_id']; // Corrected session variable name
} else {
    $error_message = "User ID not found in session.";
}

// Fetch user details
if (!isset($error_message)) { 
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id); // Ensure user_id is used here
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();
}

// Handle sub-category registration
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
    header('Location: user_dashboard.php');
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
   
    if (!empty($name) && !empty($email) && !empty($phone_no)) {
        $query = "UPDATE users SET name = ?, email = ?, phone_no = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $name, $email, $phone_no, $user_id);

        if ($stmt->execute()) {
            $success_message = "Profile updated successfully!";
            // Refresh user data
            $user['username'] = $name;
            $user['email'] = $email;
            $user['phone_no'] = $phone_no;
        } else {
            $error_message = "Error updating profile: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error_message = "Please fill in all fields.";
    }
}

// Fetch all sub-categories
$sub_categories = [];
$query = "SELECT * FROM sub_categories";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sub_categories[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">User Dashboard</h1>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
        <?php endif; ?>

        <!-- User Profile -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>My Profile</h3>
            </div>
            <div class="card-body">
                <form action="update_profile.php" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="phone_no">Phone Number</label>
                        <input type="text" name="phone_no" id="phone_no" class="form-control" value="<?php echo htmlspecialchars($user['phone_no']); ?>" required>
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-primary mt-3">Update Profile</button>
                </form>
            </div>
        </div>

        <!-- Sub-Category Registration -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Register for a Sub-Category</h3>
            </div>
            <div class="card-body">
                <form action="user_dashboard.php" method="post">
                    <div class="form-group">
                        <label for="sub_category_id">Select a Sub-Category</label>
                        <select name="sub_category_id" id="sub_category_id" class="form-control" required>
                            <option value="">-- Select a Sub-Category --</option>
                            <?php foreach ($sub_categories as $sub_category): ?>
                                <option value="<?php echo $sub_category['id']; ?>" <?php echo isset($user['sub_category_id']) && $sub_category['id'] == $user['sub_category_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($sub_category['sub_category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="register_sub_category" class="btn btn-primary mt-3">Register</button>
                </form>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="text-center mt-4">
            <form action="logout.php" method="post">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
