<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
require_once "./connection.php";

$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$updateSuccess = false;
$updateError = false;

if ($course_id > 0) {
    // Fetch course details
    $query = "SELECT * FROM course WHERE course_id = $course_id";
    $result = mysqli_query($db, $query);
    $course = mysqli_fetch_assoc($result);
    if (!$course) {
        $updateError = true;
    }
} else {
    $updateError = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$updateError) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $language = mysqli_real_escape_string($db, $_POST['language']);
    $duration = mysqli_real_escape_string($db, $_POST['duration']);
    $price = floatval($_POST['price']);
    $update_query = "UPDATE course SET title='$title', description='$description', language='$language', duration='$duration', price=$price WHERE course_id=$course_id";
    if (mysqli_query($db, $update_query)) {
        $updateSuccess = true;
        // Refresh course data
        $course = [
            'title' => $title,
            'description' => $description,
            'language' => $language,
            'duration' => $duration,
            'price' => $price
        ];
    } else {
        $updateError = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Course</title>
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/allUpdatePage.css">
</head>
<body>
    <div class="container">
        <div class="update-form">
            <h3 class="mb-4">Update Course
                <a href="admin_dashboard.php" class="btn btn-danger" style="float: right; margin-left: auto;">&larr; Back to Dashboard</a>
            </h3>
            <?php if ($updateSuccess): ?>
                <div class="alert alert-success">Course updated successfully!</div>
            <?php elseif ($updateError): ?>
                <div class="alert alert-danger">Error updating course. Please try again.</div>
            <?php endif; ?>
            <?php if (!$updateError): ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($course['title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" required><?php echo htmlspecialchars($course['description']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Language</label>
                    <input type="text" name="language" class="form-control" value="<?php echo htmlspecialchars($course['language']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-control" value="<?php echo htmlspecialchars($course['duration']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($course['price']); ?>" required>
                </div>
                <button type="submit" class="btn btn-warning">Update Course</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
