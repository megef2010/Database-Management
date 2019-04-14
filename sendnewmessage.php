<?php
	session_name('MetubeSession');
	session_start();
	$myDB = new mysqli('localhost', 'metube', 'SuperSecurePassword', 'metube');

	$sender = $_POST['id'];
	$receiver = $_POST['to'];
	$message = $_POST['$messagebody'];

	$myDB->query("INSERT INTO messages (sendid, recvid, text) VALUES ('$sender', '$receiver', '$message')");
  header('Location: MeTubeMessage.html?errorMessage="Email Sent"', true, 200);
	exit();
?>

