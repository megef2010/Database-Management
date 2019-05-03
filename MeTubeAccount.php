<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>MeTube/Account</title>
	<link rel="stylesheet" type="text/css" href="MeTube.css">
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; ?>
	<?php
	if ( isset( $_GET[ 'id' ] ) ) {
		$id = mysql_real_escape_string( $_GET[ 'id' ] );
		$result = mysql_query( "SELECT name, description FROM users WHERE id='$id'" );
		$row = mysql_fetch_row( $result );
		?>
	<h1>
		<?php echo $row[0];?>
	</h1>
	<?php echo $row[1]; ?>
	<?php 
		if(isowner('account', $_GET['id']))
		{ ?>
	<form class="profile" action="operation.php" method="post">
		<textarea name="description" cols="40" rows="5"><?php echo $row[1]; ?></textarea>
		<input type="hidden" name="action" value="profile"/>
		<input value="Update Description" name="submit" type="submit"/>
	</form>
	<form class="passchange" action="MeTubeChangePassword.php">
		<input type="submit" name="submit" value="Change Password"/>
	<?php }
		else { 
			if ( isset( $_SESSION[ 'userID' ] ) ) {?>
			<form class="contact" action="operation.php" method="post">
				<?php
<<<<<<< HEAD

		      			if ( @mysql_result(mysql_query("SELECT COUNT(*) FROM usercontacts WHERE userid=". $_SESSION[ 'userID' ] . " AND contactid='$id'"), 0) != 0 ) {?>


=======
		      			if ( mysql_result(mysql_query("SELECT COUNT(*) FROM usercontacts WHERE userid=". $_SESSION[ 'userID' ] . " AND contactid=$id"), 0) ) {?>
>>>>>>> origin/notemplate-test
						
						<input type="hidden" name="action" value="removecontacts"/>
						<input type="hidden" name="contact" value="<?php echo '$id'; ?>"/>
						<input type="submit" name="submit" value="Remove From Contacts"/>
					<?php }
		      			else { ?>
						<input type="hidden" name="action" value="addcontacts"/>
						<input type="hidden" name="contact" value="<?php echo '$id'; ?>"/>
						<input type="submit" name="submit" value="Add To Contacts"/>
					<?php } ?>
			</form>
		<?php } } }
	else { 
		echo '<meta http-equiv="refresh" content="0;url=MeTube.php">';
	 } ?>
	<h2>My Account</h2>

	<h3>Media</h3>


	<div id="Anav">
		<h3>
			<div id="Vid">
				Media
				<div id="VidScroll">
					<?php
					$query = "SELECT id, title FROM media WHERE userid='$id'";
					$results = mysql_query( $query );
					while ( $row = mysql_fetch_row( $results ) ) {
						?>
					<a href="MeTubeView.php?id=<?php echo $row[0];?>" target="_blank">
						<?php echo $row[1];?>
					</a> <br>
					<?php } ?>
				</div>
			</div>
			<div id="Pla">
				Playlists <?php if(isowner('account',$_GET['id'])) echo "(<a href=\"MeTubePlaylist.php\">Manage</a>)"; ?>
				<div id="PlaScroll">
					<?php
					$query = "SELECT playlists.id, playlists.name FROM playlists WHERE playlists.userid='$id'";
					$results = mysql_query( $query );
					while ( $row = mysql_fetch_row( $results ) ) {
						?>
					<a href="MeTubePlaylist.php?id=<?php echo $row[0];?>" target="_blank">
						<?php echo $row[1];?>
					</a>
					<?php } ?>
				</div>
			</div>
			<div id="Fav">
				Favorites
				<div id="FavScroll">
					<?php
					$query = "SELECT media.id, media.title FROM media INNER JOIN favorites ON favorites.mediaid=media.id WHERE favorites.userid='$id'";
					$results = mysql_query( $query );
					while ( $row = mysql_fetch_row( $results ) ) {
						?>
					<a href="MeTubeView.php?id=<?php echo $row[0];?>" target="_blank">
						<?php echo $row[1];?><br>
					</a>
					<?php } ?>

				</div>
			</div>
			<?php if(isowner('account', $_GET['id'])) { ?>
			<div id="Mes">
				Messages (<a href="MeTubeMessage.php">Compose</a>)

				<div id="MesScroll">
					<?php
					$query = "SELECT messages.id, messages.subject, messages.text, messages.sendid FROM messages INNER JOIN users ON messages.recvid=users.id WHERE messages.recvid='$id'";
					if ( $results = mysql_query( $query ) ) {
						echo '<table>';
						while ( $row = mysql_fetch_row( $results ) ) {
							$secondq = "SELECT users.name FROM users WHERE users.id=".$row[3];
							$sender = mysql_result(mysql_query( $secondq ),0);
							echo "<tr><td>From: " . $sender . "</td></tr><tr><td><a href=\"MeTubeReply.php?id=".$row[0]."\" target=\"_blank\">" . $row[ 1 ] . "</a></td></tr>";
						}
						echo '</table>';
					}
					?>
				</div>
			</div>
			<?php } ?>
			<div id="Con">
				Subscriptions
				<div id="ConScroll">
					<?php
					$query = "SELECT users.id, users.name FROM users INNER JOIN subscribers ON subscribers.channelid=users.id WHERE subscribers.userid='$id'";
					$results = mysql_query( $query );
					while ( $row = mysql_fetch_row( $results ) ) {
						?>
					<a href="MeTubeAccount.php?id=<?php echo $row[0];?>" target="_blank">
						<?php echo $row[1];?>
					</a>
					<?php } ?>
				</div>
			</div>
		
		</h3>
	</div>

</body>
</html>
