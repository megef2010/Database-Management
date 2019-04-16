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
	<div id="SeaScroll">
		<?php if(isset($_GET['id'])) {
			$id = mysql_real_escape_string($_GET['id']);
			$result = mysql_query("SELECT media.name, media.description FROM media INNER JOIN playlistcontent ON media.id = playlistcontent.mediaid WHERE playlistcontent.playlistid='$id'" );
			$row = mysql_fetch_row($result);
		
			echo "<table>";
			while($col = mysql_fetch_array($result)){   //Creates a loop to loop through results
				echo "<tr><td>" . $col['name'] . "</td><td>" . $col['description'] . "</td></tr>";  //$col['index'] the index here is a field name
			}
			echo "</table>";
		?>
	</div>
</body>
</html>