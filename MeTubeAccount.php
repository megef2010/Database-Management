<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>MeTube/Account</title>
	<link rel="stylesheet" type="text/css" href="MeTube.css">
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; 
	include_once "function.php";?>
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
		if($id == $_SESSION['userID'])
		{ ?>
	<form class="profile" action="operation.php" method="post">
		<textarea name="description" cols="100" rows="75"><?php echo $row[1]; ?></textarea>
		<input type="hidden" name="action" value="profile"/>
		<input value="Update Description" name="submit" type="submit"/>
	</form>
	<?php } }
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
					</a>
					<?php } ?>
				</div>
			</div>
			<div id="Pla">
				Playlists
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
						<?php echo $row[1];?>
					</a>
					<?php } ?>

				</div>
			</div>
			<div id="Mes">
				Messages
				<form class="NewMessage" action="MeTubeMessage.php?id=<?php echo '$id';?>">
					<button type="submit" value="Compose">Compose</button>
				</form>
				<div id="MesScroll">
					<?php
					$query = "SELECT messages.id, messages.text, messages.sendid FROM messages INNER JOIN users ON messages.recvid=user.id WHERE messages.recvid='$id'";
					if ( $results = mysql_query( $query ) ) {
						echo '<table>';
						while ( $row = mysql_fetch_row( $results ) ) {
							$secondq = "SELECT user.name FROM users WHERE users.id='$row[2]'";
							$sender = mysql_query( $secondq );
							echo '<a href="MeTubeReply.php?id=$id&message=$row[0]" target="_blank">';
							echo '<tr><h4>From: ' . $sender . '</h4></tr><tr>' . $row[ 1 ] . '</tr>';
							echo '</a>';
						}
					}
					?>
				</div>
			</div>
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