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
		echo '<meta http-equiv="refresh" content="0;url=MeTubeSignIn.php?err=1">';
		exit();
	}
	
	$sql = "SELECT id FROM users WHERE name='$username'";
	$results = $myDB->query($sql);
	$arr = $results->fetch_assoc();

	$id = $arr['id'];

	$_SESSION['username'] = $username;
	$_SESSION['userID'] = $id;
	

	echo '<meta http-equiv="refresh" content="0;url=MeTube.php">';
	exit();
?>

