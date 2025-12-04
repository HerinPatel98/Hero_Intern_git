<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
require_once "./connection.php";

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$updateSuccess = false;
$updateError = false;

if ($user_id > 0) {
    $query = "SELECT * FROM user WHERE user_id = $user_id";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);
    if (!$user) {
        $updateError = true;
    }
} else {
    $updateError = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$updateError) {
    $fname = mysqli_real_escape_string($db, $_POST['fname']);
    $lname = mysqli_real_escape_string($db, $_POST['lname']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $language1 = mysqli_real_escape_string($db, $_POST['language1']);
    $language2 = mysqli_real_escape_string($db, $_POST['language2']);
    $experience = mysqli_real_escape_string($db, $_POST['experience']);
    $update_query = "UPDATE user SET fname='$fname', lname='$lname', username='$username', email='$email', language1='$language1', language2='$language2', experience='$experience' WHERE user_id=$user_id";
    if (mysqli_query($db, $update_query)) {
        $updateSuccess = true;
        $user = [
            'fname' => $fname,
            'lname' => $lname,
            'username' => $username,
            'email' => $email,
            'language1' => $language1,
            'language2' => $language2,
            'experience' => $experience
        ];
    } else {
        $updateError = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body { background: #eaf4fb; }
        .update-form {
            background: #f4faff;
            border: 2px solid #2575fc;
            border-radius: 1.2rem;
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem 2.5rem;
            box-shadow: 0 2px 12px rgba(37, 116, 252, 0.19);
        }
        .form-label { color: #2575fc; font-weight: bold; }
        .form-control:focus { border-color: #2575fc; box-shadow: 0 0 0 0.2rem #eaf4fb; }
        .btn-primary { background: #2575fc; color: #fff; border: none; }
        .btn-primary:hover { background: #6a11cb; color: #fff; }
        .alert-success { background: #e3f0ff; color: #2575fc; border: 1px solid #2575fc; }
        .alert-danger { background: #fff3cd; color: #856404; border: 1px solid #ffe082; }
    </style>
</head>
<body>
    <div class="container">
        <div class="update-form">
            <h3 class="mb-4">Update User
                <a href="allUsers.php" class="btn btn-danger" style="float: right; margin-left: auto;">&larr; Back to Users</a>
            </h3>
            <?php if ($updateSuccess): ?>
                <div class="alert alert-success">User updated successfully!</div>
            <?php elseif ($updateError): ?>
                <div class="alert alert-danger">Error updating user. Please try again.</div>
            <?php endif; ?>
            <?php if (!$updateError): ?>
            <form method="post" class="d-flex flex-column justify-content-center" style="min-height: 60vh;">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($user['fname']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lname" class="form-control" value="<?php echo htmlspecialchars($user['lname']); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Language 1</label>
                        <input type="text" name="language1" class="form-control" value="<?php echo htmlspecialchars($user['language1']); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Language 2</label>
                        <input type="text" name="language2" class="form-control" value="<?php echo htmlspecialchars($user['language2']); ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Experience</label>
                    <input type="text" name="experience" class="form-control" value="<?php echo htmlspecialchars($user['experience']); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update User</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
