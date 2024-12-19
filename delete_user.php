<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete User - Pancho's Website</title>
    <link rel="stylesheet" type="text/css" href="css/include.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        // JavaScript function to display alert and redirect
        function showErrorAndRedirect(message) {
            alert(message);
            window.location.href = 'register-view-users2.php'; // Redirect to the specified page
        }
    </script>
</head>
<body>
<div id="container">
    <?php include('nav.php'); ?>

    <div id="content">
        <h2>Delete User</h2>
        <?php
        require('mysqli_connect.php');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            if ($_POST['sure'] == 'Yes') {
                // Perform deletion
                $q = "DELETE FROM users WHERE user_id=$id";
                $result = mysqli_query($dbcon, $q);

                if ($result && mysqli_affected_rows($dbcon) == 1) {
                    // Use JavaScript to show an alert and then redirect
                    echo "<script>
                            alert('The user has been successfully deleted.');
                            window.location.href = 'register-view-users2.php';
                          </script>";
                    exit(); // Ensure no further code is executed                
                } else {
                    echo '<p class="error">Could not delete the user. Please try again.</p>';
                    header("Location: register-view-users2.php");
                    exit();
                }
            } else {
                echo '<p>User was not deleted.</p>';
                header("Location: register-view-users2.php");
                exit();
            }
        } elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            $q = "SELECT CONCAT(fname, ' ', lname) AS full_name, email FROM users WHERE user_id=$id";
            $result = mysqli_query($dbcon, $q);

            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $full_name = htmlspecialchars($row['full_name']);
                $email = htmlspecialchars($row['email']);

                echo '<div class="delete-container">';
                echo "<h3>Are you sure you want to delete the following user?</h3>";
                echo "<p><strong>Name:</strong> $full_name</p>";
                echo "<p><strong>Email:</strong> $email</p>";
                echo '<form method="post" action="delete_user.php">
                        <input type="hidden" name="id" value="' . $id . '">
                        <p><input type="radio" name="sure" value="Yes"> Yes</p>
                        <p><input type="radio" name="sure" value="No" checked> No</p>
                        <p><input type="submit" value="Submit"></p>
                      </form>';
                echo '</div>';
            } else {
                // User not found case - Trigger JavaScript alert and redirect
                echo "<script>showErrorAndRedirect('User not found.');</script>";
            }
        } else {
            // Invalid user ID case - Trigger JavaScript alert and redirect
            echo "<script>showErrorAndRedirect('Invalid user ID.');</script>";
        }

        mysqli_close($dbcon);
        ?>
    </div>
    <?php include('footer.php'); ?>
</div>
</body>
</html>
