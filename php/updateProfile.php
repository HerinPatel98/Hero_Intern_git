<?php
// filepath: c:\xampp\htdocs\Hero_Intern\php\updateProfile.php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('You need to login first!');window.location.href='login.php';</script>";
    exit();
}
require_once("connection.php");
$username = $_SESSION['username'];

// Fetch current user data
$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = mysqli_real_escape_string($db, $_POST['fname']);
    $lname = mysqli_real_escape_string($db, $_POST['lname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $language1 = mysqli_real_escape_string($db, $_POST['language1']);
    $language2 = mysqli_real_escape_string($db, $_POST['language2']);
    $experience = mysqli_real_escape_string($db, $_POST['experience']);

    $updateQuery = "UPDATE user SET 
        fname='$fname', 
        lname='$lname', 
        email='$email', 
        password='$password', 
        language1='$language1', 
        language2='$language2', 
        experience='$experience'
        WHERE username='$username'";

    if (mysqli_query($db, $updateQuery)) {
        echo "<script>alert('Profile updated successfully!');window.location.href='userProfile.php';</script>";
        exit();
    } else {
        $error = "Failed to update profile.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Profile | Hero Intern</title>
    <style>
        body {
            background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%);
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .update-container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(120, 144, 156, 0.12);
            padding: 36px 32px;
        }

        h2 {
            text-align: center;
            color: #3a506b;
            margin-bottom: 24px;
        }

        form label {
            display: block;
            margin-top: 16px;
            color: #5c677d;
            font-weight: 500;
        }

        form input,
        form select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #e0eafc;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .form-actions {
            margin-top: 28px;
            display: flex;
            justify-content: space-between;
        }

        .profile-btn {
            background: #e0eafc;
            color: #3a506b;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
        }

        .profile-btn:hover {
            background: #cfdef3;
        }

        .error {
            color: #d7263d;
            text-align: center;
            margin-bottom: 12px;
        }

        .profile-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .profile-td-left,
        .profile-td-right {
            vertical-align: top;
            padding: 0 12px 0 0;
            width: 50%;
        }

        .profile-td-left {
            border-right: 1px solid #e0eafc;
        }

        .profile-td-right {
            padding-left: 12px;
        }

        @media (max-width: 700px) {
            .update-container {
                max-width: 98vw;
                padding: 18px 8px;
            }
            .profile-table {
                display: block;
                width: 100%;
            }
            .profile-table tr,
            .profile-table td {
                display: block;
                margin-left: 30px;
                width: 100%;
                border: none;
                padding: 0;
            }
            .profile-td-left,
            .profile-td-right {
                border-right: none;
                padding: 0;
                width: 100%;
            }
            .profile-td-right {
                padding-left: 0;
            }
            .form-actions {
                flex-direction: column;
                gap: 12px;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <div class="update-container">
        <h2>Update Profile</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <table class="profile-table">
                <tr>
                    <td class="profile-td-left">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" required value="<?= htmlspecialchars($user['fname'] ?? '') ?>">
                    </td>
                    <td class="profile-td-right">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" required value="<?= htmlspecialchars($user['lname'] ?? '') ?>">
                    </td>
                </tr>
                <tr>
                    <td class="profile-td-left">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                    </td>
                    <td class="profile-td-right">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required value="<?= htmlspecialchars($user['password'] ?? '') ?>">
                    </td>
                </tr>
                <tr>
                    <td class="profile-td-left">
                        <label for="language1">Primary Language</label>
                        <input type="text" name="language1" id="language1" value="<?= htmlspecialchars($user['language1'] ?? '') ?>">
                    </td>
                    <td class="profile-td-right">
                        <label for="language2">Secondary Language</label>
                        <input type="text" name="language2" id="language2" value="<?= htmlspecialchars($user['language2'] ?? '') ?>">
                    </td>
                </tr>
                <td colspan="2">
                    <label for="experience">Experience</label>
                    <input type="text" name="experience" id="experience" value="<?= htmlspecialchars($user['experience'] ?? '') ?>">
                </td>
                </tr>
            </table>

            <div class="form-actions">
                <a href="userProfile.php" class="profile-btn">&larr; Cancel</a>
                <button type="submit" class="profile-btn">Update</button>
            </div>
        </form>
    </div>
</body>

</html>