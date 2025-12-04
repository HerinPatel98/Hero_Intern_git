<?php
require_once("./connection.php");

$registerSuccess = false;
$registerError = false;
$errors = [];
extract($_POST);
if (isset($_POST['submit'])) {
    if ( // check if any field is empty
        empty($firstname) || empty($lastname) || empty($email) ||
        empty($username) || empty($password) || empty($language1) ||
        empty($language2) || !isset($experience)
    ) {
        $registerError = true;
        $errors[0] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // check email format with php filter
        $registerError = true;
        $errors[1] = "Invalid email address.";
    } else {
        // Registration success
        $registerSuccess = true;

        $query = "INSERT INTO `user`
        (`fname`, `lname`, `username`, `password`, `email`, `language1`, `language2`, `experience`)
        VALUES
        ('$firstname', '$lastname', '$username', '$password', '$email', '$language1', '$language2', '$experience')";

        mysqli_execute_query($db, $query);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hero Intern | Registration</title>
    <link rel="stylesheet" href="../styles/register.css">
</head>

<body>
    <div class="register-container">
        <div class="rocket">🚀</div>
        <h2>Create Your Account</h2>
        <p>Join the Hero Intern Community</p>
        <form method="POST">
            <div class="form-row">
                <input type="text" name="firstname" placeholder="First Name" autofocus autocapitalize>
                <input type="text" name="lastname" placeholder="Last Name" autocapitalize>
            </div>
            <input type="email" name="email" placeholder="Email Address">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="New Password for this Site">
            <div class="form-row">
                <input type="text" name="language1" placeholder="Language 1">
                <input type="text" name="language2" placeholder="Language 2">
            </div>
            <input type="text" name="experience" placeholder="Experience">
            <button type="submit" name="submit" value="register">REGISTER</button>
        </form>

        <?php if ($registerSuccess): ?>
            <div class="message success">✅ Registration
                successful! You can now <a href="./login.php">login</a>.</div>
        <?php elseif ($registerError): ?>
            <div class="message error">
                <?php foreach ($errors as $error): ?>
                    <div>❌ <?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>