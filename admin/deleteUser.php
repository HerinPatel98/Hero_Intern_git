<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
require_once "./connection.php";

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($user_id > 0) {
    $delete_query = "DELETE FROM user WHERE user_id = $user_id";
    if (mysqli_query($db, $delete_query)) {
        echo '<script>alert("User deleted successfully!"); window.location.href = "allUsers.php";</script>';
        exit();
    } else {
        echo '<script>alert("Error deleting user. Please try again."); window.location.href = "allUsers.php";</script>';
        exit();
    }
} else {
    header("Location: allUsers.php");
    exit();
}
?>
