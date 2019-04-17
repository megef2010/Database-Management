<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>MeTube/Create</title>
	<link rel="stylesheet" type="text/css" href="MeTube.css">
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; ?>
	<form class="signin" action="operation.php" method="post" align="center">
		<!-- Links to PHP file for signing in. -->
		<p>Username <input type="text" name="username" required><br><br> Password <input type="password" name="password" required><br><br> Description <input type="text" name="description"><br><br>
			<input type="hidden" name="action" value="create"/>
			<input type="submit" value="Submit">
		</p>
	</form>
	<p align="center" style="font-size: 13px">Already have an account? Click <a href="MeTubeSignIn.php">here</a> to got to it.</p>
</body>
</html>