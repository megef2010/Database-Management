<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MeTube/Search</title>
<link rel="stylesheet" type="text/css" href="MeTube.css"> 
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; 
	include_once "function.php";?>
	<?php
	if(isset($_GET['id'])) {
		$id = mysql_real_escape_string($_GET['id']);
		$result = mysql_query("SELECT name, description FROM users WHERE id='$id'" );
		$row = mysql_fetch_row($result);
	?>
		<h1><?php echo $row[0];?></h1>
		<?php echo $row[1]; ?>
	<?php 
		if($id == $_SESSION['userID'])
		{ ?>
			<form class="profile" action="update_profile.php" method="post">
			<textarea name="description"><?php echo $row[1]; ?></textarea>
			<input type="hidden" name="userid" value=<?php echo '"' . $_SESSION['userID'] . '"'; ?>/>
			<input value="Update Description" name="submit" type="submit" />
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
			<div id="VidScroll"><?php
		$query = "SELECT id, title FROM media WHERE userid='$id'";
		$results = mysql_query($query);
		while($row = mysql_fetch_row($results)) {
	?>
			<a href="MeTubeView.php?id=<?php echo $row[0];?>" target="_blank"><?php echo $row[1];?></a>
	<?php } ?></div>
		</div>
		<div id="Pla">
			Playlists
			<div id="PlaScroll">
			<?php
		$query = "SELECT playlists.id, playlists.name FROM playlists WHERE playlists.userid='$id'";
		$results = mysql_query($query);
		while($row = mysql_fetch_row($results)) {
	?>
			<a href="MeTubePlaylist.php?id=<?php echo $row[0];?>" target="_blank"><?php echo $row[1];?></a>
	<?php } ?>
			</div>
		</div>
		<div id="Fav">
			Favorites
			<div id="FavScroll">
			<?php
		$query = "SELECT media.id, media.title FROM media INNER JOIN favorites ON favorites.mediaid=media.id WHERE favorites.userid='$id'";
		$results = mysql_query($query);
		while($row = mysql_fetch_row($results)) {
	?>
			<a href="MeTubeView.php?id=<?php echo $row[0];?>" target="_blank"><?php echo $row[1];?></a>
	<?php } ?>
			
			</div>
		</div>
		<div id="Mes">
			Messages
			<div id="MesScroll"></div>
		</div>
		<div id="Con">
			Subscriptions
			<div id="ConScroll"></div>
		</div>
	</h3>
	</div>
	
</body>
</html>
