<?php
session_start();

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['user_level'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('mysqli_connect.php');

    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_psword'];
    $new_password = $_POST['new_psword'];
    $confirm_password = $_POST['confirm_psword'];

    // Validate passwords
    $errors = [];
    
    // Check if old password is provided
    if (empty($old_password)) {
        $errors[] = "Please enter your old password.";
    }

    // Check if new password and confirm password match
    if (empty($new_password) || empty($confirm_password)) {
        $errors[] = "Please enter a new password and confirm it.";
    } elseif ($new_password !== $confirm_password) {
        $errors[] = "New password and confirmation password do not match.";
    }

    // If no errors, proceed to validate old password and update
    if (empty($errors)) {
        // Fetch the current password hash from the database
        $q = "SELECT psword FROM users WHERE user_id = '$user_id'";
        $result = @mysqli_query($dbcon, $q);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $hashed_password = $row['psword'];

            // Verify if the old password matches the stored hash
            if (password_verify($old_password, $hashed_password)) {
                // Hash the new password
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_q = "UPDATE users SET psword = '$new_hashed_password' WHERE user_id = '$user_id'";
                if (@mysqli_query($dbcon, $update_q)) {
                    echo "<p>Password changed successfully.</p>";
                } else {
                    echo "<p>Error updating password. Please try again later.</p>";
                }
            } else {
                $errors[] = "Old password is incorrect.";
            }
        } else {
            $errors[] = "User not found.";
        }

        // Show any errors
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p class='error'>$error</p>";
            }
        }

        mysqli_free_result($result);
        mysqli_close($dbcon);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="css/include.css">
    <meta charset="utf-8">
</head>
<body>
    <div id="container">
        <?php include('nav_admin.php'); ?>

        <div id="content">
        <div id="hero-section">
<h2><center>CHANGE PASSWORD</center></h2>
        <div class="form-box">
        <form action="change_password.php" method="POST">
                <center>
                <label for="old_psword">Old Password:</label>
                <input type="password" id="old_psword" name="old_psword" required><br><br>

                <label for="new_psword">New Password:</label>
                <input type="password" id="new_psword" name="new_psword" required><br><br>

                <label for="confirm_psword">Confirm New Password:</label>
                <input type="password" id="confirm_psword" name="confirm_psword" required><br><br>

                <button type="submit">Confirm</button>
                </center>
            </form>
        </div>
    </div>
    </div>
        <?php include('footer.php'); ?>
    </div>
</body>
</html>
