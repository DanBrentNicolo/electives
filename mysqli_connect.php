    <?php
$dbcon = @mysqli_connect('localhost', 'danbnp', 'danbnp', 'members_pancho')
OR die('could not connect to MySQL server.'. mysqli_connect_error());
mysqli_set_charset($dbcon, 'utf8');
?>