<?php
session_start();
include('db_connect.php');

// Ensure admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Unset login flag after successful login check
if (isset($_SESSION['login_from_login_php'])) {
    unset($_SESSION['login_from_login_php']);
}

// Fetch all dance categories
$categories = [];
$query = "SELECT * FROM dance_categories";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Fetch all registered participants
$participants = [];
$query = "SELECT u.id, u.username, u.email, u.phone_no, d.category_name 
          FROM users u 
          LEFT JOIN dance_categories d ON u.sub_category_id = d.id";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $participants[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Admin Dashboard</h1>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
        <?php endif; ?>

        <!-- Add Dance Category -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Add Dance Category</h3>
            </div>
            <div class="card-body">
                <form action="add_category.php" method="post">
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" name="category_name" id="category_name" class="form-control" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="dance_type">Dance Type</label>
                        <input type="text" name="dance_type" id="dance_type" class="form-control" required>
                    </div>
                    <button type="submit" name="add_category" class="btn btn-primary mt-3">Add Category</button>
                </form>
            </div>
        </div>

        <!-- View Registered Participants -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Registered Participants</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone No</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($participants)): ?>
                            <?php foreach ($participants as $index => $participant): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($participant['username']); ?></td>
                                    <td><?php echo htmlspecialchars($participant['email']); ?></td>
                                    <td><?php echo htmlspecialchars($participant['phone_no']); ?></td>
                                    <td><?php echo htmlspecialchars($participant['category_name'] ?? 'Not Assigned'); ?></td>

                                    <td>
                                        <form action="delete_user.php" method="post" style="display:inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $participant['id']; ?>">
                                            <button type="submit" name="delete_user" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No participants registered.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Search Participants -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Search Participants</h3>
            </div>
            <div class="card-body">
                <form action="search_user.php" method="post">
                    <div class="form-group">
                        <input type="text" name="search_term" class="form-control" placeholder="Enter username to search">
                    </div>
                    <button type="submit" name="search_user" class="btn btn-primary mt-3">Search</button>
                </form>

                <?php if (isset($_SESSION['search_results']) && !empty($_SESSION['search_results'])): ?>
                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone No</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['search_results'] as $index => $result): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($result['username']); ?></td>
                                    <td><?php echo htmlspecialchars($result['email']); ?></td>
                                    <td><?php echo htmlspecialchars($result['phone_no']); ?></td>
                                    <td><?php echo htmlspecialchars($result['category_name']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php unset($_SESSION['search_results']); ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="text-center mt-4">
            <form action="logout.php" method="post">
                <button type="submit" name="logout" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
<br/> <br/>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>


