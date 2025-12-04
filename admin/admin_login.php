<!-- admin_login.php -->
<?php
session_start();
require_once "./connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE admin_name='$username' AND password='$password'";
    $result = $db->query($query);

    if ($result->num_rows == 1) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "Invalid credentials. Please try again.";
    }
}
?>

<!-- admin_login.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #007bff, #6c757d);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
            text-align: center;
            position: relative;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: #333;
            cursor: default;
        }

        .login-container .logo {
            font-size: 2.5rem;
            margin-bottom: 10px;
            cursor: default;
        }

        .login-container input {
            margin: 10px 0;
            padding: 12px;
            width: 94%;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 1rem;
        }

        .login-container button {
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
            width: 94%;
        }

        .login-container button:hover {
            background: #0056b3;
        }

        .login-container p {
            margin-top: 15px;
            font-size: 0.9rem;
            color: #6c757d;
            cursor: default;
        }

        .alert {
            margin-top: 20px;
            position: absolute;
            bottom: 10px;
            left: 4%;
            width: 92%;
        }
    </style>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>
    <div class="login-container">
        <div class="logo">🚀</div>
        <h2>Admin Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="👤Username" required />
            <input type="password" name="password" placeholder="🔐Password" required />
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>
        <p>Welcome back, Admin! Please log in to continue.</p>
        <p>Cancel login. <a onclick="history.back()" style="color: blue; cursor: pointer;">Go Back</a></p>
    </div>
</body>

</html>