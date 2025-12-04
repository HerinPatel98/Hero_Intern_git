<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Call for Interns</title>
    <link rel="stylesheet" href="../styles/index.css">
</head>

<body>
    <header>
        <div class="logo">🦄 Hero Intern</div>
        <nav>
            <ul class="menu">
                <li> <a href="#">Home</a> </li>
                <li> <a href="../admin/admin_login.php">Admin</a></li>
                <li> <a href="#">Contact Us</a></li>
                <li> <a href="#">FAQs</a></li>
                <li> <a href="#">Careers</a></li>
            </ul>
        </nav>
    </header>
    <main class="hero-section">
        <div class="left">
            <h2>CALL FOR <span>INTERNS</span></h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempor, magna non sodales.</p>
            <form method="post" action="./register.php">
                <button type="submit" name="get_started">Register</button>
            </form>
        </div>
        <div class="right">
            <!-- <img src="" alt="Intern Icon" class="illustration"> -->
            <span class="rocket"> 🚀 </span> <h4> Already registered? </h4>
            <form method="post" action="./login.php">
                <button class="apply-btn" type="submit" name="apply_now">LOGIN NOW</button>
            </form>
        </div>
    </main>
    <?php include_once("./footer.php");
    ?>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['get_started'])) {
        echo "<script>alert('Get Started Clicked!');</script>";
    }
    if (isset($_POST['apply_now'])) {
        echo "<script>alert('Apply Now Clicked!');</script>";
    }
}
?>