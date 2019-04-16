<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>MeTube/Message</title>
	<link rel="stylesheet" type="text/css" href="MeTube.css">
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; 
	include_once "function.php";
  
	if($_SESSION['userID'] == isset($_GET['id'])) {
	} 	
	else { 
		echo '<meta http-equiv="refresh" content="0;url=MeTube.php">';
	 } ?>

	<br><br>
	<h2>New Message</h2>

	<div id="newMessage">
		<form class="newMessage" action="operation.php" method="post">
			<input type="text" name="to" value="To..."><br><br>
			<textarea name="messagebody" cols="100" rows="75">Your message here...</textarea><br><br>
			<input type="hidden" name="action" value="message"/>
			<input type="submit" value="Send">

		</form>
	</div>

</body>

</html>