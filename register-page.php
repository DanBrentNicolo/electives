<!DOCTYPE html>
<html lang="en">
<head><title>Registration Page | Pancho's Website</title>
<link rel="stylesheet" type="text/css" href="css/include.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div id="container">
        <?php include('nav.php');?>
    <div id="content">
    <?php
require('mysqli_connect.php'); // Include database connection
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name
    if (empty($_POST["fname"])) {
        $errors[] = 'Please enter your first name.';
    } else {
        $fn = trim($_POST["fname"]);
    }

    // Validate last name
    if (empty($_POST["lname"])) {
        $errors[] = 'Please enter your last name.';
    } else {
        $ln = trim($_POST["lname"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $errors[] = 'Please enter your email.';
    } else {
        $e = mysqli_real_escape_string($dbcon, trim($_POST["email"]));
    }

    // Validate password
    if (empty($_POST["psword1"])) {
        $errors[] = 'Please enter your password.';
    } elseif ($_POST["psword1"] != $_POST["psword2"]) {
        $errors[] = 'Your passwords do not match.';
    } else {
        $p = trim($_POST["psword1"]);
        $hashed_password = password_hash($p, PASSWORD_DEFAULT);
    }

    // Check for existing email
    if (empty($errors)) {
        $check_query = "SELECT email FROM users WHERE email='$e'";
        $check_result = mysqli_query($dbcon, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $errors[] = 'The email address is already registered. Please use another.';
        }
    }

    // Insert user into database
    if (empty($errors)) {
        $q = "INSERT INTO users (fname, lname, email, psword, registration_date) 
              VALUES ('$fn', '$ln', '$e', '$hashed_password', NOW())";
        if(mysqli_query($dbcon, $q)){
            header("Location: register-thanks-alert.php");
            exit();
        } else {
            echo '<h2>System Error</h2><p class="error">Could not register due to a system error. Please try again later.</p>';
        }
    }

    // Display errors
    if (!empty($errors)) {
        echo '<script>alert("The following error(s) occurred:\\n·  ' . implode('\\n·  ', $errors) . '");</script>';
    }
}
?>

<div id="hero-section">
<h2><center>Registration Form</center></h2>
<div class="form-box">
    <form action="register-page.php" method="post">
        <center>
        <table>
            <tr><p>
            <label class="label" for="fname"><td align="right">First Name:</td></label>
            <td align="left"><input type="text" id="fname" name="fname" size="30" maxlenght="40" value="<?php if(isset($_POST["fname"])) echo $_POST["fname"]?>"></td>
            </p></tr>      

            <tr><p>
            <label class="label" for="lname"><td align="right">Last Name:</td></label>
            <td align="left"><input type="text" id="lname" name="lname" size="30" maxlenght="40" value="<?php if(isset($_POST["lname"])) echo $_POST["lname"]?>"></td>
            </p></tr>

            <tr><p>
            <label class="label" for="email"><td align="right">Email:</td></label>
            <td align="left"><input type="email" id="email" name="email" size="30" maxlenght="50" value="<?php if(isset($_POST["email"])) echo $_POST["email"]?>"></td>
            </p></tr>

            <tr><p>
            <label class="label" for="psword1"><td align="right">Password:</td></label>
            <td align="left"><input type="password" id="psword1" name="psword1" size="30" maxlenght="20" value="<?php if(isset($_POST["psword1"])) echo $_POST["psword1"]?>"></td>
            </p></tr>

            <tr><p>
            <label class="label" for="psword2"><td align="right">Confirm Password:</td></label>
            <td align="left"><input type="password" id="psword2" name="psword2" size="30" maxlenght="20" value="<?php if(isset($_POST["psword2"])) echo $_POST["psword2"]?>"></td>
            </p></tr>
    </table>
    <p><input type="submit" id="submit" name="submit" value="Register"></p>
        </center>
    </form> 
</div>
</div>
</div>
<?php include('footer.php');?>
</body>
</html>