<?php
	session_name('MetubeSession');
	session_start();
	include_once "function.php";;
	$myDB = mysqli_connect('localhost', 'metube', 'SuperSecurePassword', 'metube');
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}

	$sender = $_POST['id'];
	$receiver = $_POST['to'];
	$message = $_POST['$messagebody'];

	$receiverid = mysqli_query($myDB, "SELECT id FROM user WHERE name=$receiver");

	$myDB->query("INSERT INTO messages (sendid, recvid, text) VALUES ('$sender', '$receiverid', '$message')");
  	echo '<a href="MeTubeAccount.html">';
	mysqli_close($myDB);
	exit();
?>

