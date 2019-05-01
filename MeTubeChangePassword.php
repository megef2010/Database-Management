<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>MeTube/Password Change</title>
	<link rel="stylesheet" type="text/css" href="MeTube.css">
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php';?>
	<?php if(@$_GET['err'] == 1) {
	echo 'Passwords do not match.';
	}?>
	<p><form class="newpass" action="operation.php" align="center" method="post">
		New Password <input type="password" name="password" required><br><br>
		Confirm New Password <input type="password" name="conpassword" required><br><br>
		<input type="hidden" name="action" value="newpass"/>
		<input type="submit" value="Submit"><br><br>
	</form></p>

</body>
</html>
