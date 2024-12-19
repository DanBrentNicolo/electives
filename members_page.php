<?php
session_start();

// If there is no valid session (user is not logged in), redirect to login
if (!isset($_SESSION['user_level'])) {
    header("Location: login.php");
    exit();
}

// Prevent caching of the page
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
header("Expires: 0"); // For proxies
?>
<!DOCTYPE html>
<html lang="en">
<head><title>Pancho's Website</title>
<link rel="stylesheet" type="text/css" href="css/include.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div id="container">
<?php include('nav_member.php');?>
<?php include('info-col.php');?>
<?php include('footer.php');?>
</div>
</body>
</html>