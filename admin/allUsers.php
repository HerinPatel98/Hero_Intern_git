<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
require_once "./connection.php";

// SQL: Select all users
$users_query = 'SELECT user_id, fname, lname, username, email, language1, language2, experience FROM user';
$users_result = mysqli_query($db, $users_query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hero Intern | All Users</title>
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
    <style>
        /* Slightly different shade for users page */
        .custom-navbar {
            background: linear-gradient(310deg, #6a11cb 0%, #2575fc 100%) !important;
        }
        .accordion-button {
            background: #e3f0ff;
        }
        .accordion-item {
            border-color: #2575fc;
        }
        .btn-back {
            background: #2575fc;
            color: #fff;
            border-radius: 1.1rem;
            padding: 8px 18px;
            border: none;
        }
        .btn-back:hover {
            background: #1127cb6b;
            color: #fff;
        }
    </style>
</head>
<body style="background-color: dodgerblue;">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <div class="custom-navbar">
        <span class="brand">All Users</span>
        <div class="navbar-content">
            <span class="welcome">Welcome, <?php echo isset($_SESSION['admin']) ? htmlspecialchars($_SESSION['admin']) : 'Admin'; ?></span>
            <div class="button-group" id="buttonGroup">
                <a href="admin_dashboard.php"><button class="btn-back" type="button">&larr; Back</button></a>
                <a href="admin_logout.php"><button class="custom-btn btn-danger" type="button">Logout</button></a>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="accordion w-100" id="usersAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingUsers">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
                        Users
                    </button>
                </h2>
                <div id="collapseUsers" class="accordion-collapse collapse show" aria-labelledby="headingUsers" data-bs-parent="#usersAccordion">
                    <div class="accordion-body">
                        <h5>All Registered Users</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>UID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Language 1</th>
                                        <th>Language 2</th>
                                        <th>Experience</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($users_result)) {
                                        echo '<tr>';
                                        echo '<td>' . $i++ . '</td>';
                                        echo '<td>' . htmlspecialchars($row['user_id']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['fname']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['lname']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['language1']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['language2']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['experience']) . '</td>';
                                        echo '<td class="text-center">';
                                        echo '<a href="viewApplications.php?id=' . $row['user_id'] . '" class="btn btn-primary me-2">View</a>';
                                        echo '<a href="updateUser.php?id=' . $row['user_id'] . '" class="btn btn-warning me-2">Update</a>';
                                        echo '<a href="deleteUser.php?id=' . $row['user_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this user?\')">Delete</a>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="mt-3 text-end">
                                <a href="../php/register.php" class="btn btn-primary" style="border-radius: 1.1rem;">
                                    <span style="font-size:1.2em;">&#43;</span> Add User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
