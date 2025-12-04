<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
require_once "./connection.php";

// Get user id from query string
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($user_id <= 0) {
    echo "<div style='color:red;'>Invalid user ID.</div>";
    exit();
}

// Fetch user details
$user_query = "SELECT user_id, fname, lname, username, email, language1, language2, experience FROM user WHERE user_id = $user_id";

$user_result = mysqli_query($db, $user_query);
$user = mysqli_fetch_assoc($user_result);

if (!$user) {
    echo "<div style='color:red;'>User not found.</div>";
    exit();
}

// Remove application if requested
$remove_message = '';
if (isset($_GET['remove_type']) && isset($_GET['remove_id'])) {
    $remove_type = $_GET['remove_type'];
    $remove_id = intval($_GET['remove_id']);
    $success = false;
    if ($remove_type === 'course') {
        $delete_sql = "DELETE FROM user_course WHERE id = $remove_id AND user_id = $user_id";
    } elseif ($remove_type === 'internship') {
        $delete_sql = "DELETE FROM user_internship WHERE id = $remove_id AND user_id = $user_id";
    } elseif ($remove_type === 'job') {
        $delete_sql = "DELETE FROM user_job WHERE id = $remove_id AND user_id = $user_id";
    } else {
        $delete_sql = '';
    }
    if ($delete_sql) {
        $success = mysqli_query($db, $delete_sql);
    }
    $msg = $success ? 'Application removed successfully.' : 'Failed to remove application.';
    header("Location: viewApplications.php?id=$user_id&msg=" . urlencode($msg) . "&msgtype=" . ($success ? 'success' : 'danger'));
    exit();
}

// Fetch all course applications
$course_apps = [];
$sql = "SELECT uc.id, 'course' AS type, c.title, c.language, c.price as amount, uc.application_date, NULL as req_exp
        FROM user_course uc 
        JOIN course c 
        ON uc.course_id = c.course_id 
        WHERE uc.user_id = $user_id";

$res = mysqli_query($db, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    $course_apps[] = $row;
}

// Fetch all internship applications
$internship_apps = [];
$sql = "SELECT ui.id, 'internship' AS type, i.title, i.req_language AS language, i.price as amount, ui.application_date, NULL as req_exp
        FROM user_internship ui
        JOIN internship i
        ON ui.internship_id = i.internship_id 
        WHERE ui.user_id = $user_id";

$res = mysqli_query($db, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    $internship_apps[] = $row;
}

// Fetch all job applications
$job_apps = [];
$sql = "SELECT uj.id, 'job' AS type, j.title, NULL as language, j.req_exp, uj.application_date, NULL as amount
        FROM user_job uj 
        JOIN job j 
        ON uj.job_id = j.job_id 
        WHERE uj.user_id = $user_id";
$res = mysqli_query($db, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    // For jobs, use req_exp as 'Experience Required' and leave language blank
    $row['price'] = $row['req_exp'];
    $row['language'] = '';
    $job_apps[] = $row;
}

// Merge all applications
$all_apps = array_merge($course_apps, $internship_apps, $job_apps);

// Sort by application_date desc
usort($all_apps, function ($a, $b) {
    return strtotime($b['application_date']) - strtotime($a['application_date']);
});

?>
<!DOCTYPE html>
<html>

<head>
    <title>User Applications | Hero Intern</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container.custom-app-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(120, 144, 156, 0.10);
            padding: 32px 24px;
        }

        .user-details-title {
            color: #2575fc;
        }

        .table-user-details {
            width: 75%;
            margin-bottom: 1.5rem;
        }

        .applications-title {
            color: #2575fc;
        }

        .btn-back {
            background: #2575fc;
            color: #fff;
            border-radius: 1.1rem;
            padding: 8px 18px;
            border: none;
            transition: background 0.6s;
        }

        .btn-back:hover {
            background: #1952a6 !important;
            color: #fff !important;
        }

        @media (max-width: 900px) {
            .table-user-details {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4 custom-app-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="user-details-title">User Details</h2>
            <a href="allUsers.php" class="btn btn-back">&larr; Back</a>
        </div>
        <table class="table table-bordered table-responsive table-hover table-user-details">
            <tr>
                <th>User ID</th>
                <td><?= htmlspecialchars($user['user_id']) ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?= htmlspecialchars($user['fname'] . ' ' . $user['lname']) ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?= htmlspecialchars($user['username']) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
            <tr>
                <th>Language 1</th>
                <td><?= htmlspecialchars($user['language1']) ?></td>
            </tr>
            <tr>
                <th>Language 2</th>
                <td><?= htmlspecialchars($user['language2']) ?></td>
            </tr>
            <tr>
                <th>Experience</th>
                <td><?= htmlspecialchars($user['experience']) ?></td>
            </tr>
        </table>
        <h3 class="applications-title">Applications</h3>
        <?php if (isset($_GET['msg']) && $_GET['msg']): ?>
            <div class="alert alert-<?= isset($_GET['msgtype']) ? htmlspecialchars($_GET['msgtype']) : 'info' ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['msg']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Type</th>
                        <th>Title</th>
                        <th>Language</th>
                        <th>Price</th>
                        <th>Req. Exp.</th>
                        <th>Applied At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($all_apps as $app) {
                        echo '<tr class="text-center">';
                        echo '<td>' . $i++ . '</td>';
                        echo '<td>' . htmlspecialchars(ucfirst($app['type'])) . '</td>';
                        echo '<td>' . htmlspecialchars($app['title']) . '</td>';
                        echo '<td>' . htmlspecialchars($app['language']) . '</td>';
                        echo '<td>' . htmlspecialchars($app['amount']) . '</td>';
                        echo '<td>' . htmlspecialchars($app['req_exp']) . '</td>';
                        echo '<td>' . htmlspecialchars($app['application_date']) . '</td>';
                        echo '<td><a href="viewApplications.php?id=' . $user_id . '&remove_type=' . $app['type'] . '&remove_id=' . $app['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Remove this application?\')">Remove</a></td>';
                        echo '</tr>';
                    }
                    if ($i === 1) {
                        echo '<tr><td colspan="7" class="text-center">No applications found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="../js/bootstrap.bundle.min.js"></script>
</html>