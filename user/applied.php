<!-- Popup Notification -->

<?php
session_start();
require_once("../admin/connection.php");

$uname = isset($_SESSION['username']) ? $_SESSION['username'] : (isset($_GET['uname']) ? $_GET['uname'] : '');
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Get user details (simple SQL)
$user_id = 0;
$user = null;
if ($uname) {
    $sql = "SELECT * FROM user WHERE username='" . mysqli_real_escape_string($db, $uname) . "'";
    $res = mysqli_query($db, $sql);
    if ($row = mysqli_fetch_assoc($res)) {
        $user_id = $row['user_id'];
        $user = $row;
    }
}

// Get course details (simple SQL)
$course = null;
if ($course_id) {
    $sql = "SELECT * FROM course WHERE course_id=$course_id";
    $cres = mysqli_query($db, $sql);
    if ($crow = mysqli_fetch_assoc($cres)) {
        $course = $crow;
    }
}

$show_alert = false;
$internship_alert = false;
$job_alert = false;
$internship = null;
if ($user_id && $type === 'course' && $course_id) {
    // Count current courses (simple SQL)
    $sql = "SELECT COUNT(*) AS cnt FROM user_course WHERE user_id=$user_id";
    $cntres = mysqli_query($db, $sql);
    $cntrow = mysqli_fetch_assoc($cntres);
    if ($cntrow['cnt'] >= 2) {
        $show_alert = true;
    } else {
        // Insert new course application (simple SQL)
        $sql = "INSERT INTO user_course (user_id, course_id) VALUES ($user_id, $course_id)";
        mysqli_query($db, $sql);
    }
}

// Internship application logic (only one per user, and not if ongoing job)
if ($user_id && $type === 'internship' && $course_id) {
    // Check if user has an ongoing job
    $sql = "SELECT COUNT(*) AS cnt FROM user_job WHERE user_id=$user_id";
    $jres = mysqli_query($db, $sql);
    $jrow = mysqli_fetch_assoc($jres);
    if ($jrow['cnt'] >= 1) {
        $job_alert = true;
    } else {
        // Check if user already has an internship
        $sql = "SELECT COUNT(*) AS cnt FROM user_internship WHERE user_id=$user_id";
        $ires = mysqli_query($db, $sql);
        $irow = mysqli_fetch_assoc($ires);
        if ($irow['cnt'] >= 1) {
            $internship_alert = true;
        } else {
            // Insert new internship application
            $sql = "INSERT INTO user_internship (user_id, internship_id) VALUES ($user_id, $course_id)";
            mysqli_query($db, $sql);
            // Get internship details
            $sql = "SELECT * FROM internship WHERE internship_id=$course_id";
            $ires2 = mysqli_query($db, $sql);
            if ($irow2 = mysqli_fetch_assoc($ires2)) {
                $internship = $irow2;
            }
        }
    }
}

$job_error = false;
$job = null;
if ($user_id && $type === 'job' && $course_id) {
    // Check if user already has an ongoing job
    $sql = "SELECT COUNT(*) AS cnt FROM user_job WHERE user_id=$user_id";
    $ongoingJobRes = mysqli_query($db, $sql);
    $ongoingJobRow = mysqli_fetch_assoc($ongoingJobRes);
    if ($ongoingJobRow['cnt'] >= 1) {
        $job_error = 'You can only apply for one job at a time.';
    } else {
        // Get job details
        $sql = "SELECT * FROM job WHERE job_id=$course_id";
        $jobres = mysqli_query($db, $sql);
        if ($jobrow = mysqli_fetch_assoc($jobres)) {
            $job = $jobrow;
            // Check if job position is available
            if ($jobrow['position'] <= 0) {
                $job_error = 'This job is no longer available.';
            } else {
                // Check if user has ongoing internship
                $sql = "SELECT COUNT(*) AS cnt FROM user_internship WHERE user_id=$user_id";
                $ures = mysqli_query($db, $sql);
                $urow = mysqli_fetch_assoc($ures);
                if ($urow['cnt'] >= 1) {
                    $job_error = 'You cannot apply for a job while you have an ongoing internship.';
                } else {
                    // Check user experience
                    $user_exp = isset($user['experience']) ? intval($user['experience']) : 0;
                    $req_exp = intval($jobrow['req_exp']);
                    if ($user_exp < $req_exp) {
                        $job_error = 'You do not meet the required experience for this job.';
                    } else {
                        // Check if user already has a job (for this job)
                        $sql = "SELECT COUNT(*) AS cnt FROM user_job WHERE user_id=$user_id AND job_id=$course_id";
                        $jres = mysqli_query($db, $sql);
                        $jrow = mysqli_fetch_assoc($jres);
                        if ($jrow['cnt'] >= 1) {
                            $job_error = 'You have already applied for this job.';
                        } else {
                            // Insert new job application
                            $sql = "INSERT INTO user_job (user_id, job_id) VALUES ($user_id, $course_id)";
                            if (mysqli_query($db, $sql)) {
                                // Decrement job position
                                $sql = "UPDATE job SET position = position - 1 WHERE job_id=$course_id AND position > 0";
                                mysqli_query($db, $sql);
                            } else {
                                $job_error = 'Failed to apply for the job.';
                            }
                        }
                    }
                }
            }
        } else {
            $job_error = 'Job not found.';
        }
    }
}

?>

<head>
    <link rel="stylesheet" href="../styles/dashboard.css">
    <title>Applied Successfully | Hero Intern</title>
</head>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f7f9fc;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .success-card {
        background: white;
        padding: 30px 40px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        text-align: center;
    }

    h2 {
        color: #2e7d32;
        margin-bottom: 10px;
    }

    .info {
        margin-top: 20px;
        text-align: left;
    }

    .info p {
        margin: 8px 0;
        font-size: 16px;
    }

    .back-btn {
        margin-top: 20px;
        display: inline-block;
        padding: 10px 20px;
        background-color: #1976d2;
        color: white;
        border-radius: 8px;
        text-decoration: none;
    }
</style>
</head>

<body>
    <div class="success-card">
        <h2> Your Application Has Been Submitted</h2>
        <div class="info">
            <p><strong>Name:</strong> <?= htmlspecialchars($user['fname'] ?? $uname) ?> <?= htmlspecialchars($user['lname'] ?? '') ?></p>
            <p><strong>Username:</strong> <?= htmlspecialchars($uname) ?></p>
            <?php if ($course): ?>
                <p><strong>Course:</strong> <?= htmlspecialchars($course['title']) ?></p>
                <p><strong>Description:</strong> <?= htmlspecialchars($course['description']) ?></p>
                <p><strong>Language:</strong> <?= htmlspecialchars($course['language']) ?></p>
                <p><strong>Duration:</strong> <?= htmlspecialchars($course['duration']) ?></p>
                <p><strong>Price:</strong> ₹<?= number_format($course['price']) ?></p>
            <?php endif; ?>
            <?php if ($internship): ?>
                <p><strong>Internship:</strong> <?= htmlspecialchars($internship['title']) ?></p>
                <p><strong>Description:</strong> <?= htmlspecialchars($internship['description']) ?></p>
                <p><strong>Required Language:</strong> <?= htmlspecialchars($internship['req_language']) ?></p>
                <p><strong>Price:</strong> ₹<?= number_format($internship['price']) ?></p>
            <?php endif; ?>
        </div>
        <a href="./dashboard.php" class="back-btn">Back to Home</a>
    </div>
    <div id="apply-popup">
        <span class="tick">&#10003;</span>
        <span>Applied Successfully!</span>
    </div>
    <script>
        // Show popup on page load
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('apply-popup');
            setTimeout(() => {
                popup.classList.add('show');
            }, 500);
            setTimeout(() => {
                popup.classList.remove('show');
            }, 3000);
            <?php if ($show_alert): ?>
                alert('You can only enroll in up to 2 courses at a time.');
                window.location.href = './dashboard.php';
            <?php endif; ?>
            <?php if ($internship_alert): ?>
                alert('You can only apply for one internship at a time.');
                window.location.href = './dashboard.php';
            <?php endif; ?>
            <?php if ($job_alert): ?>
                alert('You cannot apply for an internship while you have an ongoing job.');
                window.location.href = './dashboard.php';
            <?php endif; ?>
            <?php if ($job_error): ?>
                alert('<?= addslashes($job_error) ?>');
                window.location.href = './dashboard.php';
            <?php endif; ?>
        });
    </script>