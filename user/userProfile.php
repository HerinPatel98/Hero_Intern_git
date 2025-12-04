<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('You need to login first!');window.location.href='login.php';</script>";
    exit();
}
require_once("connection.php");
$username = $_SESSION['username'];
$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Hero Intern</title>
    <style>
        body {
            background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%);
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #3a506b;
        }
        .profile-container {
            max-width: 500px;
            margin: 10px auto 5px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(120, 144, 156, 0.12);
            padding: 36px 32px;
            text-align: center;
        }
        .profile-avatar {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(120, 144, 156, 0.10);
            margin-bottom: 18px;
        }
        .profile-name {
            font-size: 2rem;
            font-weight: 600;
            color: #3a506b;
            margin-bottom: 8px;
        }
        .profile-username {
            font-size: 1.1rem;
            color: #6c7a89;
            margin-bottom: 38px;
        }
        .profile-details {
            text-align: left;
            margin: 0 auto 24px auto;
            max-width: 350px;
        }
        .profile-details dt {
            font-weight: 500;
            color: #5c677d;
            margin-top: 12px;
        }
        .profile-details dd {
            margin: 0 0 8px 0;
            color: #3a506b;
        }
        .profile-actions {
            display: flex;
            justify-content: center;
            gap: 18px;
        }
        .profile-btn, .logout-btn {
            background: #e0eafc;
            color: #3a506b;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }
        .profile-btn:hover, .logout-btn:hover {
            background: #cfdef3;
        }
        @media (max-width: 600px) {
            .profile-container {
                max-width: 98vw;
                padding: 18px 8px;
            }
            .profile-details {
                max-width: 98vw;
                font-size: 0.98rem;
                margin-left: 20px;
            }
            .profile-name {
                font-size: 1.3rem;
            }
            .profile-avatar {
                width: 70px;
                height: 70px;
                margin-bottom: 12px;
            }
            .profile-actions {
                flex-direction: column;
                gap: 10px;
            }
            .profile-btn, .logout-btn {
                width: 100%;
                padding: 10px 0;
                font-size: 0.98rem;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <img src="../Images/car1.jpg" alt="Profile Avatar" class="profile-avatar">
        <div class="profile-name">
            <?= htmlspecialchars(($user['fname'] ?? $username) . ' ' . ($user['lname'] ?? '')) ?>
        </div>
        <div class="profile-username">@<?= htmlspecialchars($username) ?></div>
        <dl class="profile-details">
            <dt>Email</dt>
            <dd><?= htmlspecialchars($user['email'] ?? 'Not Provided') ?></dd>
            <dt>Password</dt>
            <dd>
                <?php
                    $hiddenText = $user['password'] ?? '';
                    echo str_repeat('*', strlen($hiddenText));
                ?>
            </dd>
            <dt>Primary Language</dt>
            <dd><?= htmlspecialchars($user['language1'] ?? 'Not Provided') ?></dd>
            <dt>Secondry Language</dt>
            <dd><?= htmlspecialchars($user['language2'] ?? 'Not Provided') ?></dd>
            <dt>Experience</dt>
            <dd><?= htmlspecialchars($user['experience'] ?? 'Not Provided') ?></dd>
        </dl>
        <div class="profile-actions">
            <a href="dashboard.php" class="profile-btn">&larr; Back to Dashboard</a>
            <a href="updateProfile.php" class="profile-btn">Update Profile</a>
            <a href="user_logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>
