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

			$id = $Post['searchbar'];

			$sqlq = "SELECT name, description FROM media WHERE name LIKE '%$id%' OR tag='$id' OR category='$id' OR user LIKE '%$id%'";

			$result = mysql_query($sqlq);

			echo "<table>";

			while($col = mysql_fetch_array($result)){   //Creates a loop to loop through results

				echo "<tr><td>" . $col['name'] . "</td><td>" . $col['description'] . "</td></tr>";  //$col['index'] the index here is a field name

			}

			echo "</table>";

			mysql_close($myDB);

		?><!-- Display search results here -->
	</div>
</body>
</html>
