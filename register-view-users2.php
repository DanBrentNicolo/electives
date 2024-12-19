<?php
session_start();

// Redirect to login if the session is not valid
if (!isset($_SESSION['user_level'])) {
    header("Location: login.php");
    exit();
}

// Prevent caching (add this right after starting the session)
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
header("Expires: 0"); // Proxies
?>
<!DOCTYPE html>
<html lang="en">
	<head><title>Pancho's Website</title>
    <link rel="stylesheet" type="text/css" href="css/include.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
<body>
<div id="container">

<?php include('nav_admin.php');?>
	<div id="content">
    <h2>Registered Users</h2>
    <div class="table-box">
    
	<p>
    <?php 
        require("mysqli_connect.php");

        $q = "SELECT user_id, fname, lname, email, DATE_FORMAT(registration_date, '%M %d, %Y') AS regdat FROM users ORDER BY user_id ASC";
        $result = mysqli_query($dbcon, $q);

        if ($result) {
            echo '<table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>';

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo '<tr>
                        <td>' . $row['fname'] . ' ' . $row['lname'] . '</td>
                        <td>' . $row['email'] . '</td>
                        <td>' . $row['regdat'] . '</td>
                        <td><a href="edit_user.php?id=' . $row['user_id'] . '"><i class="fas fa-pen icon"></i></a></td>
                        <td><a href="delete_user.php?id=' . $row['user_id'] . '"><i class="fas fa-trash icon"></i></a></td>
                    </tr>';
            }
            echo '</table>';
            mysqli_free_result($result);
        } else {
            echo '<p class="error">Error: ' . mysqli_error($dbcon) . '</p>';
        }

        mysqli_close($dbcon);
    ?>
	</p>
    </div>
</div>
<?php include('footer.php');?>
</body>
</html>