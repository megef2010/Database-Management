<?php
	session_name('MetubeSession');
	session_start();

	$myDB = new mysqli('localhost', 'metube', 'SuperSecurePassword', 'metube');

	$username = $_POST['email'];
	$username = $myDB->real_escape_string($username);
	$password = $_POST['password'];
	$password = md5($password);

	
	if($myDB->query("SELECT COUNT(*) FROM users WHERE name = '$username' AND password = '$password'") !== 1){

		session_unset();
		session_destroy();
		header('Location: MeTubeSignIn.html?errorMessage="Incorrect Username or Password."', true, 302);
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
