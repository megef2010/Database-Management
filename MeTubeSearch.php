<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MeTube/Search</title>
<link rel="stylesheet" type="text/css" href="MeTube.css"> 
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; ?>

	<!-- Template for Search Page. Vertical scrollbar with videos displayed found in PHP search. -->
	<div id="SeaScroll">
		<?php

			$myDB = mysql_connect('localhost', 'metube', 'SuperSecurePassword');

			mysql_select_db('metube');

			$id = $_POST['searchbar'];

			$sqlq = "SELECT media.id, media.name, media.description FROM media LEFT JOIN mediatags WHERE media.name LIKE '%$id%' OR media.category = '$id' OR mediatags.tag = '$id' OR media.user LIKE '%$id%'";

			if ( $result = mysql_query($sqlq) ) {

			echo "<table>";

			while($col = mysql_fetch_row($result)){   //Creates a loop to loop through results

				echo "<a href="MeTubeView.php?id=$col['id']"><tr><td>" . $col['name'] . "</td><td>" . $col['description'] . "</td></tr></a>";  //$col['index'] the index here is a field name

			}

			echo "</table>"; }

			mysql_close($myDB);

		?><!-- Display search results here -->
	</div>
</body>
</html>
