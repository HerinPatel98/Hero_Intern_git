<!-- UserDetail.php -->
<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('You need to login first!');
            window.location.href = 'login.php';
        </script>";
    exit();
}
require_once "./connection.php";

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}
extract($_SESSION);
$user_query = "SELECT user_id, username FROM user WHERE username = '$username'";
$user_result = mysqli_query($db, $user_query);
$user_row = mysqli_fetch_array($user_result);
$row_user_id = $user_row['user_id'];


// SQL: Select all courses
$courses_query = "SELECT * FROM vw_user_course WHERE user_id = '$row_user_id'";
$courses_result = mysqli_query($db, $courses_query);

// SQL: Select all internships
$internships_query = "SELECT * from vw_user_internship WHERE user_id = '$row_user_id'";
$internships_result = mysqli_query($db, $internships_query);

// SQL: Select all jobs
$jobs_query = "SELECT * FROM vw_user_job WHERE user_id = '$row_user_id'";
$jobs_result = mysqli_query($db, $jobs_query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Internship Applications</title>
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
</head>

<body style="background-color: #ffc0e658;">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Modern Custom Navbar with Hamburger Menu for Buttons -->
    <div class="custom-navbar" style="background: linear-gradient(90deg, purple 450px, pink);">
        <span class="brand">User Dashboard</span>
        <div class="navbar-content">
            <span class="welcome">Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Unknown User'; ?></span>
            <!-- Button group, collapses on mobile -->
            <div class="button-group" id="buttonGroup">
                <!-- <button class="custom-btn btn-light" type="button">Contact Us</button> -->
                <!-- <button class="custom-btn btn-light" type="button">Button 2</button> -->
                <a href="./contact.php"><button class="custom-btn btn-light" type="button">Contact Us</button></a>
                <a href="./dashboard.php"><button class="custom-btn btn-danger" type="button">Home</button></a>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="accordion w-100" id="adminAccordion">
            <!-- Accordion Item 1: Courses -->
            <div class="accordion-item" >
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Courses
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#adminAccordion">
                    <div class="accordion-body">
                        <!-- Courses Table -->
                        <h5>Courses</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Language</th>
                                        <th>Duration</th>
                                        <th>Price</th>
                                        <th>Application Date</th>
                                        <!-- <th class="text-center">More</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($courses_result)) {
                                        echo '<tr>';
                                        echo '<td>' . $i++ . '</td>';
                                        echo '<td>' . $row['title'] . '</td>';
                                        echo '<td>' . $row['description'] . '</td>';
                                        echo '<td>' . $row['language'] . '</td>';
                                        echo '<td>' . $row['duration'] . '</td>';
                                        echo '<td>' . $row['price'] . '</td>';
                                        echo '<td>' . $row['application_date'] . '</td>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Accordion Item 2: Internships -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Internships
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#adminAccordion">
                    <div class="accordion-body">
                        <!-- Internships Table -->
                        <h5>Internships</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Required Language</th>
                                        <th>Price</th>
                                        <th>Application Date</th>
                                        <!-- <th>Edit</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($internships_result)) {
                                        echo '<tr>';
                                        echo '<td>' . $i++ . '</td>';
                                        echo '<td>' . $row['title'] . '</td>';
                                        echo '<td>' . $row['description'] . '</td>';
                                        echo '<td>' . $row['req_language'] . '</td>';
                                        echo '<td>' . $row['price'] . '</td>';
                                        echo '<td>' . $row['application_date'] . '</td>';
                                    echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Accordion item 3: Jobs -->
             <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Jobs
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#adminAccordion">
                    <div class="accordion-body">
                        <!-- Jobs Table -->
                        <h5>Jobs</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Position</th>
                                        <th>Required Experience</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($jobs_result)) {
                                        echo '<tr>';
                                        echo '<td>' . $i++ . '</td>';
                                        echo '<td>' . $row['title'] . '</td>';
                                        echo '<td>' . $row['description'] . '</td>';
                                        echo '<td>' . $row['position'] . '</td>';
                                        echo '<td>' . $row['req_exp'] . '</td>';
                                    echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>