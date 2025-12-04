<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
require_once "./connection.php";

$internship_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$updateSuccess = false;
$updateError = false;

if ($internship_id > 0) {
    // Fetch internship details
    $query = "SELECT * FROM internship WHERE internship_id = $internship_id";
    $result = mysqli_query($db, $query);
    $internship = mysqli_fetch_assoc($result);
    if (!$internship) {
        $updateError = true;
    }
} else {
    $updateError = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$updateError) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $req_language = mysqli_real_escape_string($db, $_POST['req_language']);
    $price = floatval($_POST['price']);
    $update_query = "UPDATE internship SET title='$title', description='$description', req_language='$req_language', price=$price WHERE internship_id=$internship_id";
    if (mysqli_query($db, $update_query)) {
        $updateSuccess = true;
        // Refresh internship data
        $internship = [
            'title' => $title,
            'description' => $description,
            'req_language' => $req_language,
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
    <title>Update Internship</title>
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/allUpdatePage.css">
</head>
<body>
    <div class="container">
        <div class="update-form">
            <h3 class="mb-4">Update Internship
                <a href="admin_dashboard.php" class="btn btn-danger" style="float: right; margin-left: auto;">&larr; Back to Dashboard</a>
            </h3>
            <?php if ($updateSuccess): ?>
                <div class="alert alert-success">Internship updated successfully!</div>
            <?php elseif ($updateError): ?>
                <div class="alert alert-danger">Error updating internship. Please try again.</div>
            <?php endif; ?>
            <?php if (!$updateError): ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($internship['title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" required><?php echo htmlspecialchars($internship['description']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Required Language</label>
                    <input type="text" name="req_language" class="form-control" value="<?php echo htmlspecialchars($internship['req_language']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($internship['price']); ?>" required>
                </div>
                <button type="submit" class="btn btn-warning">Update Internship</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
