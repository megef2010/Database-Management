<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>MeTube/Message</title>
	<link rel="stylesheet" type="text/css" href="MeTube.css">
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php';   
	if(isloggedin(true)) { ?>


	<br><br>
	<h2>New Message</h2>

	<div id="newMessage">
		<form class="newMessage" action="operation.php" method="post">
			<select name="to" required>
				<option value="Contacts">To...</option>
				<?php 
				if ($contacts = mysql_query("SELECT users.name FROM users LEFT JOIN contacts ON userid=". $_SESSION['userID'] ." WHERE users.id=contacts.contactid")) {
					while ($con_row = mysql_fetch_row($contacts)) {
				?>
				<option value="<?php echo $con_row[0]; ?>"><?php echo $con_row[0]; ?>
				</option>
				<?php } } ?>
			</select>
			<input type="text" name="subject" placeholder="Subject"><br><br>
			<textarea name="messagebody" cols="40" rows="5" placeholder="Your message here"></textarea><br><br>
			<input type="hidden" name="action" value="message"/>
			<input type="submit" value="Send">

		</form>
	</div>
<?php } ?>
</body>

</html>
