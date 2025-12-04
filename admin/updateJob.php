<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
require_once "./connection.php";

$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$updateSuccess = false;
$updateError = false;

if ($job_id > 0) {
    // Fetch job details
    $query = "SELECT * FROM job WHERE job_id = $job_id";
    $result = mysqli_query($db, $query);
    $job = mysqli_fetch_assoc($result);
    if (!$job) {
        $updateError = true;
    }
} else {
    $updateError = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$updateError) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $position = mysqli_real_escape_string($db, $_POST['position']);
    $req_exp = mysqli_real_escape_string($db, $_POST['req_exp']);
    $update_query = "UPDATE job SET title='$title', description='$description', position='$position', req_exp='$req_exp' WHERE job_id=$job_id";
    if (mysqli_query($db, $update_query)) {
        $updateSuccess = true;
        // Refresh job data
        $job = [
            'title' => $title,
            'description' => $description,
            'position' => $position,
            'req_exp' => $req_exp
        ];
    } else {
        $updateError = true;
    }
}
?>
<!DOCTYPE html>
<html class="h-100">
<head>
    <title>Update Job</title>
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/allUpdatePage.css">
</head>
<body>
    <div class="container">
        <div class="update-form">
            <h3 class="mb-4">Update Job
                <a href="admin_dashboard.php" class="btn btn-danger" style="float: right; margin-left: auto;">&larr; Back to Dashboard</a>
            </h3>
            <?php if ($updateSuccess): ?>
                <div class="alert alert-success">Job updated successfully!</div>
            <?php elseif ($updateError): ?>
                <div class="alert alert-danger">Error updating job. Please try again.</div>
            <?php endif; ?>
            <?php if (!$updateError): ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($job['title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" required><?php echo htmlspecialchars($job['description']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Position</label>
                    <input type="text" name="position" class="form-control" value="<?php echo htmlspecialchars($job['position']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Required Experience</label>
                    <input type="text" name="req_exp" class="form-control" value="<?php echo htmlspecialchars($job['req_exp']); ?>" required>
                </div>
                <button type="submit" class="btn btn-warning">Update Job</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>