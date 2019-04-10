<!doctype html>
<html><!-- InstanceBegin template="/Templates/MeTubeSignIn.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>MeTube/Search</title>
<link rel="stylesheet" type="text/css" href="MeTube.css"> 
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>

<body>
	<h1>MeTube Logo <a href="MeTubeAccount.html"><img src="accountimg.jpg" width="100" height="54" align="right"></a></h1>
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
	echo '	<a href="MeTube.html">Go To Account</a>	';
	exit();
?>


	<p align="center" style="font-size: 13px">Don't have an account? Click <a href="MeTubeCreate.dwt">here</a> to make one.</p>
	<p align="center" style="font-size: 13px">Forgot your password? Click <a href="MeTubeCreate.dwt">here</a> to recover your account.</p>
</body>
<!-- InstanceEnd --></html>
