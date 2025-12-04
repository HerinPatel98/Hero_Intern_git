<!-- Login page -->
<?php
require_once("./connection.php");
session_start();

$loginSuccess = false;
$loginError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';
    
    // Simple query to validate user
    $sql = "SELECT * FROM user WHERE username = '" . $username . "' LIMIT 1";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        $loginError = true;
    } elseif ($password !== $row['password']) { // Change to password_verify if hashed
        $loginError = true;
    } else {
        $_SESSION['username'] = $username;
        $loginSuccess = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hero Intern | Login</title>
    <link rel="stylesheet" href="../styles/login.css">
</head>

<body>
    <div class="login-container">
        <div class="rocket">🚀</div>
        <h2>Login to Hero Intern</h2>
        <p>Access your internship portal</p>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" autocomplete required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" id="login-btn">LOGIN</button>
        </form>
        <?php if ($loginSuccess): ?>
            <script>
                const lgbtn = document.querySelector("#login-btn");
                lgbtn.classList.add("login-btn");
            </script>
            <div class="message success">✅ Login successful! Welcome, <b><?= htmlspecialchars($username) ?></b>.
            <br>
            <a href="./dashboard.php" class="db-link"> Go to Dashboard </a>
            </div>
        <?php elseif ($loginError): ?>
            <div class="message error">❌ Invalid username or password.</div>
        <?php endif; ?>
    </div>
</body>

</html>