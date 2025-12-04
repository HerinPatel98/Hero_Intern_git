<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
// Copy this file (connection.php) from php folder of user-side and paste in admin folder
require_once "./connection.php";

$courses_query = 'SELECT course_id, title, description, language, duration, price FROM course';
$courses_result = mysqli_query($db, $courses_query);

$internships_query = 'SELECT internship_id, title, description, req_language, price FROM internship';
$internships_result = mysqli_query($db, $internships_query);

// SQL: Select all jobs
$jobs_query = 'SELECT job_id, title, description, position, req_exp FROM job';
$jobs_result = mysqli_query($db, $jobs_query);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Hero Intern | Admin Dashboard</title>
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
</head>

<body style="background-color: #abdfff67;">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Modern Custom Navbar with Hamburger Menu for Buttons -->
    <div class="custom-navbar">
        <span class="brand">Admin Dashboard</span>
        <div class="navbar-content">
            <span class="welcome">Welcome, <?php echo isset($_SESSION['admin']) ? htmlspecialchars($_SESSION['admin']) : 'Admin'; ?></span>
            <!-- Button group, collapses on mobile -->
            <div class="button-group" id="buttonGroup">
                <a href="admin_dashboard.php"><button class="custom-btn btn-light" type="button">Home</button></a>
                <a href="allUsers.php"><button class="custom-btn btn-light" type="button">Users</button></a>
                <!-- <button class="custom-btn btn-light" type="button">Button 2</button> -->
                <a href="./admin_logout.php"><button class="custom-btn btn-danger" type="button">Logout</button></a>
            </div>
        </div>
    </div>
    <!-- Main Content: Accordions for Courses, Internships, and Jobs -->
    <div class="container-fluid mt-4">
        <div class="accordion w-100" id="adminAccordion">
            <!-- Accordion Item 1: Courses -->
            <div class="accordion-item">
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
                                        <th class="text-center">More</th>
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
                                        $course_id = $row['course_id'];
                                    ?>
                                        <td class="text-center">
                                            <a href="updateCourse.php?id=<?php echo $course_id; ?>" class="btn btn-warning">Update</a>
                                            <a href="deleteCourse.php?id=<?php echo $course_id; ?>" class="btn btn-danger delete-course" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                                        </td>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class=" d-flex justify-content-end mt-3">
                            <a href="add_course.php" class="custom-btn btn-primary" style="border-radius:1.1rem; padding:10px 20px; text-decoration:none; display:inline-flex; align-items:center;">
                                <span style="font-size:1.2em;vertical-align:middle;">&#43;</span> Add Course
                            </a>
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
                                        <th>Edit</th>
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
                                        $internship_id = $row['internship_id'];
                                    ?>
                                        <td class="text-center">
                                            <a href="updateInternship.php?id=<?php echo $internship_id; ?>" class="btn btn-warning">Update</a>
                                            <a href="deleteInternship.php.php?id=<?php echo $internship_id; ?>" class="btn btn-danger delete-course" onclick="return confirm('Are you sure you want to delete this internship?')">Delete</a>
                                        </td>
                                    <?php
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="add_internship.php" class="custom-btn btn-primary" style="border-radius:1.1rem; padding:10px 20px; text-decoration:none; display:inline-flex; align-items:center;">
                                <span style="font-size:1.2em;vertical-align:middle;">&#43; </span> Add Internship
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Accordion Item 3: Jobs -->
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
                                        <th>Edit</th>
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
                                        $job_id = $row['job_id'];
                                    ?>
                                        <td class="text-center">
                                            <a href="updateJob.php?id=<?php echo $job_id; ?>" class="btn btn-warning">Update</a>
                                            <a href="deleteJob.php?id=<?php echo $job_id; ?>" class="btn btn-danger delete-course" onclick="return confirm('Are you sure you want to delete this job?')">Delete</a>
                                        </td>
                                    <?php
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="add_job.php" class="custom-btn btn-primary" style="border-radius:1.1rem; padding:10px 20px; text-decoration:none; display:inline-flex; align-items:center;">
                                <span style="font-size:1.2em;vertical-align:middle;">&#43;</span> Add Job
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../js/bootstrap.bundle.min.js"></script>

</html>