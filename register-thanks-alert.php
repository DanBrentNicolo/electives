<!-- register-thanks.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pancho's Website</title>
    <link rel="stylesheet" type="text/css" href="css/include.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div id="container">
    <?php include('header.php');?>
    <?php include('nav.php');?>

    <div id="content">
        <?php
            echo '<script>
                    alert("Thank You for Registering!\\nYour registration was successful. You can now log in using your credentials.");
                    window.location.href = "index.php"; // Redirect to index.php after alert
                  </script>';
        ?>
    </div>
    
    <?php include('footer.php');?>
</div>
</body>
</html>
