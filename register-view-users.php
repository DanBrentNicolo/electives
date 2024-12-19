<!DOCTYPE html>
<html lang="en">
	<head><title>Pancho's Website</title>
	<link rel="stylesheet" type="text/css" href="css/include.css">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
<body>
<div id="container">
<?php include('header.php');?>
<?php include('nav.php');?>
	<div id="content">
		<h2>Registered Users</h2>
			<p>
			<?php 
				require("mysqli_connect.php");
				$q = "SELECT fname, lname, DATE_FORMAT(registration_date, '%M, %d, %Y') AS regdat from users ORDER BY user_id ASC";
				
				$result = @mysqli_query($dbcon, $q);
				if($result){
					echo '<table><tr><td><strong>Name</strong></td><td><strong>Registered Date</strong></td></tr>';
					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					echo '<tr><td>'.$row['fname'].'</td>
					<td>'.$row['regdat'].'</td>
					</tr>';			
					}
					echo'</table>';
					mysqli_free_result($result);
				}else{
					echo '<p class="error">Contact the system administrator</p>';
				}
				mysqli_close($dbcon);
			
			?>
			</p>
	</div>
</div>
<?php include('footer.php');?>
</body>
</html>