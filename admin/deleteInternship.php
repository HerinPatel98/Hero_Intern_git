<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
require_once "./connection.php";

$internship_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$deleted = false;
$error = false;

if ($internship_id > 0) {
    $delete_query = "DELETE FROM internship WHERE internship_id = $internship_id";
    if (mysqli_query($db, $delete_query)) {
        $deleted = true;
    } else {
        $error = true;
    }
} else {
    $error = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Internship</title>
    <script>
        window.onload = function() {
            <?php if ($deleted): ?>
                alert('Internship deleted successfully!');
                window.location.href = 'admin_dashboard.php';
            <?php else: ?>
                alert('Error deleting internship.');
                window.location.href = 'admin_dashboard.php';
            <?php endif; ?>
        }
    </script>
</head>
<body></body>
</html>
