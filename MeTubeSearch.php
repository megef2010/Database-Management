<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>MeTube/Search</title>
	<link rel="stylesheet" type="text/css" href="MeTube.css">
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; ?>
	<?php 
	if (isset($_POST['searchbar'])) {
		header('Location: MeTubeSearch.php?q='.$_POST['searchbar'], true, 302);	
}?>

	<!-- Template for Search Page. Vertical scrollbar with videos displayed found in PHP search. -->
	<div id="SeaScroll">
		<?php

		$id = mysql_real_escape_string( $_GET[ 'q' ] );

		$sqlq = "SELECT media.id, media.title, media.description FROM media LEFT JOIN mediatags ON media.id = mediatags.mediaid WHERE media.title LIKE '%$id%' OR media.category = '$id' OR mediatags.tag = '$id' GROUP BY media.id";
		//echo $sqlq;
		if ( $result = mysql_query( $sqlq ) ) {

			echo "<table>";

			while ( $col = mysql_fetch_row( $result ) ) { //Creates a loop to loop through results

				echo "<tr><td><a href=\"MeTubeView.php?id=" . $col[ 0 ] . "\">" . $col[ 1 ] . "</a></td></tr><tr><td>" . $col[ 2 ] . "</td></tr>"; //$col['index'] the index here is a field name

			}

			echo "</table>";
		}
		?>
		<!-- Display search results here -->
	</div>
</body>
</html>