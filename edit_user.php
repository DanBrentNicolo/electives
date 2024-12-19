<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User - Pancho's Website</title>
    <link rel="stylesheet" type="text/css" href="css/include.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div id="container">
    <?php include('nav.php'); ?>

    <div id="content">
        <h2>Edit User</h2>
        <?php
        require('mysqli_connect.php'); // Database connection

        // Check if the request is POST (form submission)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $fname = mysqli_real_escape_string($dbcon, trim($_POST['fname']));
            $lname = mysqli_real_escape_string($dbcon, trim($_POST['lname']));
            $email = mysqli_real_escape_string($dbcon, trim($_POST['email']));

            // Update the user's information
            $q = "UPDATE users SET fname='$fname', lname='$lname', email='$email' WHERE user_id=$id";
            $result = mysqli_query($dbcon, $q);

            if ($result && mysqli_affected_rows($dbcon) == 1) {
                echo '<p>The user has been successfully updated.</p>';
                header("Location: register-view-users2.php");
                exit();
            } else {
                echo '<p class="error">Error: Could not update the user. Please try again.</p>';
            }
        } else {
            // Check if the ID is passed through GET
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = $_GET['id'];
            } else {
                echo '<p class="error">Invalid user ID.</p>';
                exit();
            }

            // Fetch the user's current information
            $q = "SELECT * FROM users WHERE user_id=$id";
            $result = mysqli_query($dbcon, $q);

            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else {
                echo '<p class="error">User not found.</p>';
                exit();
            }
        }

        mysqli_close($dbcon);
        ?>
    <div class="edit-container">
        <form action="edit_user.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
            <p><label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($row['fname']); ?>" required></p>
            <p><label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($row['lname']); ?>" required></p>
            <p><label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required></p>
            <p><input type="submit" value="Update"></p>
        </form>
    </div>
</div>
<?php include('footer.php'); ?>
</div>
</body>
</html>
