<!-- PHP code for insert internship (admin) -->
<?php
require_once "./connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $req_language = $_POST['req_language'];
    $price = $_POST['price'];

    $insert_query = "INSERT INTO internship (title, description, req_language, price) VALUES ('$title', '$description', '$req_language', '$price')";

    if (mysqli_query($db, $insert_query)) {
        $success_message = "Internship added successfully!";
    } else {
        $error_message = "Error: " . mysqli_error($db);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Internship</title>
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
    <div class="container mt-5" style="background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 style="color: #343a40;">Add New Internship</h2>
            <a href="admin_dashboard.php" class="btn btn-back-dashboard">&larr; Dashboard</a>
        </div>
        <?php if (isset($success_message)) { echo "<div class='alert alert-success'>$success_message</div>"; } ?>
        <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="title" class="form-label" style="color: #495057;">Internship Title</label>
                <input type="text" class="form-control" id="title" name="title" style="border: 1px solid #ced4da; border-radius: 5px;" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label" style="color: #495057;">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" style="border: 1px solid #ced4da; border-radius: 5px;" required></textarea>
            </div>
            <div class="mb-3">
                <label for="req_language" class="form-label" style="color: #495057;">Required Language</label>
                <input type="text" class="form-control" id="req_language" name="req_language" style="border: 1px solid #ced4da; border-radius: 5px;" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label" style="color: #495057;">Price</label>
                <input type="number" class="form-control" id="price" name="price" style="border: 1px solid #ced4da; border-radius: 5px;" required>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Add Internship</button>
        </form>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>