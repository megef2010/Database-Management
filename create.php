<?php
	$myDB = new mysqli('localhost', 'metube', 'SuperSecurePassword', 'metube');
	
	$username = $_POST['email'];
	$username = $myDB->real_escape_string($username);
	$password = $_POST['password'];
	$password = md5($password);
	$description = $_POST['description'];
	$description = $myDB->real_escape_string($description);
	
	$result = mysqli_fetch_array($myDB->query("SELECT COUNT(*) FROM users WHERE name = '$username'"));
	
	
	if($result[0] !== '0'){

		session_unset();
		session_destroy();
		header('Location: MeTubeCreate.html?errorMessage="Email Taken"', true, 302);
		exit();
	}
	
	// TODO: Parse if valid email
	
	$myDB->query("INSERT INTO users (name, password, description) VALUES ('$username', '$password', '$description')");
	exit();
?>