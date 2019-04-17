<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>MeTube/Playlist</title>
	<link rel="stylesheet" type="text/css" href="MeTube.css">
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; ?>
	<!-- Template for Playlist Page. Vertical scrollbar with videos displayed found in PHP search. -->
	
		<?php 
		if ( isset( $_GET[ 'id' ] ) ) {
			echo '<div id="SeaScroll">';
			$id = mysql_real_escape_string( $_GET[ 'id' ] );
			$result = mysql_query( "SELECT media.title, media.description, media.id FROM media INNER JOIN playlistcontent ON media.id = playlistcontent.mediaid WHERE playlistcontent.playlistid='$id'" );
			

			echo "<table>";
			while ( $row = mysql_fetch_row( $result ) ) { //Creates a loop to loop through results
				echo "<tr><td><a href=MeTubeView.php?id=". $row[2] . ">" . $row[ 0 ] . "</a></td><td>" . $row[ 2 ] . "</td>"; ?>  
				<?php if(isowner('playlist', $_GET['id'])) { ?><td><form class="playlistrem" action="operation.php" method="post">
			<input type="hidden" name="playlist" value="<?php echo $_GET['id']; ?>"/>
					<input type="hidden" name="mediaid" value="<?php echo $row[2]; ?>"/>
			<input type="hidden" name="action" value="playlistrem"/>
	<input value="Remove" name="submit" type="submit"/></td>
				<?php } ?>
			<?php echo "</tr>"; }
			echo "</table>";
			echo '</div>';
		} else if(isset($_SESSION['userID'])) { ?>
			
	<h2>Manage Playlists</h2>
	<h4>Create Playlist</h4>
			<form class="playlistcreate" action="operation.php" method="post">
			<input type="text" name="playlist" placeholder="Playlist Name" required>
			<input type="hidden" name="action" value="playlistcreate"/>
			<input value="Create" name="submit" type="submit"/>
		</form>
	<h4>Your Playlists</h4>
	<table>
	<?php 
		$playlist = mysql_query("SELECT id, name FROM playlists WHERE userid=" . $_SESSION['userID']);
		while ($row = mysql_fetch_row($playlist)) {
			$count = mysql_result(mysql_query("SELECT COUNT(*) FROM playlistcontent WHERE playlistid=" . $row[0]), 0); ?>
		<tr>
		<td><a href="MeTubePlaylist.php?id=<?php echo $row[0]; ?>"><?php echo $row[1]; ?></a></td>
		<td><?php echo $count; ?> items</td>
		<td><form class="playlistdelete" action="operation.php" method="post">
						<input type="hidden" name="playlistid" value=<?php echo '"' . $row[0] . '"'; ?>/>
						<input type="hidden" name="action" value="playlistdelete"/>
						<input value="Delete" name="submit" type="submit"/>
					</form></td>
		</tr>
		
		
		<?php }
		
		?>
	
	
	</table>
	
	
	
	<?php } ?>
	
</body>
</html>