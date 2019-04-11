<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MeTube/Search</title>
<link rel="stylesheet" type="text/css" href="MeTube.css"> 
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; ?>
	<form class="signin" action="MetubeSignIn.php" align="center" method="post"><!-- Links to PHP file for signing in. -->
		<p>Username <input type="text" name="email"><br><br>
		Password <input type="password" name="password"><br><br>
		<input type="submit" value="Submit">
		</p>
	</form>
	<?php
	session_name('MetubeSession');
	session_start();

	$myDB = new mysqli('localhost', 'metube', 'SuperSecurePassword', 'metube');

	$username = $_POST['email'];
	$username = $myDB->real_escape_string($username);
	$password = $_POST['password'];
	$password = md5($password);

	$result = mysqli_fetch_array($myDB->query("SELECT COUNT(*) FROM users WHERE name = '$username' AND password = '$password'"));

	if($result[0] !== '1'){

		session_unset();
		session_destroy();
		echo 'Incorrect username or password';
		exit();
	}
	
	$sql = "SELECT id FROM users WHERE name='$username'";
	$results = $myDB->query($sql);
	$arr = $results->fetch_assoc();

	$id = $arr['id'];

	$_SESSION['username'] = $username;
	$_SESSION['userID'] = $id;
	
	echo $username . ", id: " . $id;
	echo '	<a href="MeTube.php">Go To Account</a>	';
	exit();
?>


	<p align="center" style="font-size: 13px">Don't have an account? Click <a href="MeTubeCreate.php">here</a> to make one.</p>
	<p align="center" style="font-size: 13px">Forgot your password? Click <a href="MeTubeCreate.php">here</a> to recover your account.</p>
</body>
</html>
