<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
require_once "./connection.php";

$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$deleted = false;
$error = false;

if ($job_id > 0) {
    $delete_query = "DELETE FROM job WHERE job_id = $job_id";
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
    <title>Delete Job</title>
    <script>
        window.onload = function() {
            <?php if ($deleted): ?>
                alert('Job deleted successfully!');
                window.location.href = 'admin_dashboard.php';
            <?php else: ?>
                alert('Error deleting job.');
                window.location.href = 'admin_dashboard.php';
            <?php endif; ?>
        }
    </script>
</head>
<body></body>
</html>
