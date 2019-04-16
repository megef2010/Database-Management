<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>MeTube/Search</title>
	<link rel="stylesheet" type="text/css" href="MeTube.css">
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; ?>
	<?php if(@$_GET['err'] == 1)
{
	echo 'Incorrect username or password';
}?>
	<form class="signin" action="operation.php" align="center" method="post">
		<!-- Links to PHP file for signing in. -->
		<p>Username <input type="text" name="email"><br><br> Password <input type="password" name="password"><br><br>
			<input type="hidden" name="action" value="signin"/>
			<input type="submit" value="Submit">
		</p>
	</form>



	<p align="center" style="font-size: 13px">Don't have an account? Click <a href="MeTubeCreate.php">here</a> to make one.</p>
</body>
</html>