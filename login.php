<?php
session_start();

// If already logged in, redirect to admin page
if (isset($_SESSION['user_level'])) {
    header("Location: admin_page.php");
    exit();
}

// Prevent caching of the login page
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
header("Expires: 0"); // For proxies
?>



<!DOCTYPE html>
<html lang="en">
<head><title>Pancho's Website</title>
<link rel="stylesheet" type="text/css" href="css/include.css">
<link rel="icon" href="css/Logo3.png" type="image/png" sizes="16x16">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div id="container">
<?php include('nav.php');?>
        
<div id="content">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('mysqli_connect.php');

    $e = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $p = !empty($_POST['psword']) ? trim($_POST['psword']) : null;

    if ($e && $p) {
        // Query to fetch user info based on the email
        $q = "SELECT user_id, fname, user_level, psword FROM users WHERE email = ?";
        $stmt = mysqli_prepare($dbcon, $q);
        mysqli_stmt_bind_param($stmt, 's', $e);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            // Verify the hashed password
            if (password_verify($p, $row['psword'])) {
                session_start();
                $_SESSION = $row;
                $_SESSION['user_level'] = (int) $row['user_level'];

                $url = ($_SESSION['user_level'] === 1) ? 'admin_page.php' : 'members_page.php';
                header('Location: ' . $url);
                mysqli_close($dbcon);
                exit();
            } else {
                echo '<p class="error">Invalid email or password.</p>';
            }
        } else {
            echo '<p class="error">No account found with that email. Please register first.</p>';
        }
        mysqli_free_result($result);
    } else {
        echo '<p class="error">Please fill out all fields.</p>';
    }
    mysqli_close($dbcon);
}
?>

<div id="hero-section">
<h2><center>Login</center></h2>
        <div class="form-box">
            <form action="login.php" method="post">
                <center>
                    <table>
                        <tr>
                            <td align="right"><label class="label" for="email">Email:</label></td>
                            <td align="left"><input type="email" id="email" name="email" size="30" maxlength="50" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>"></td>
                        </tr>
                        <tr>
                            <td align="right"><label class="label" for="psword">Password:</label></td>
                            <td align="left"><input type="password" id="psword" name="psword" size="30" maxlength="20"></td>
                        </tr>
                    </table>
                    <a href="register-page.php" title="Registration Page"><strong>Don't have an account? Register here.</strong></a>
                    <p><input type="submit" id="submit" name="submit" value="Login"></p>
                </center>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<?php include('footer.php');?>
</div>
</body>
</html>