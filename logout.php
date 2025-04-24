<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
session_start();
$_SESSION['logout_success'] = "Logout successful.";
header("Location: index-original.html.html");
exit();
?>
