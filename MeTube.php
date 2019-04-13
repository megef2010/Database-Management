<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MeTube</title>
<link rel="stylesheet" type="text/css" href="MeTube.css"> 
</head>

<body>
<?php include 'MeTube_GlobalHeader.php'; ?>
	<!-- Template for Homepage. Horizontal scrollbar with videos displayed under each category title. -->
	<h2>Best of MeTube</h2>
	<h3>Politics</h3>
	<div id="PolScroll">
		<?php
			$myDB = mysql_connect('localhost', 'metube', 'SuperSecurePassword');
			mysql_select_db('metube');

			$id = "Politics";
			$sqlq = "SELECT name, description FROM media WHERE category='$id'";
			$result = mysql_query($sqlq);
			echo "<table>";
			while($col = mysql_fetch_array($result)){   //Creates a loop to loop through results
				echo "<td><tr>" . $col['name'] . "</tr><tr>" . $col['description'] . "</tr></td>";  //$col['index'] the index here is a field name
			}

			echo "</table>";
			mysql_close($myDB);
			
		?><!-- Insert videos or thumbnails here with PHP. --></div>
	<h3>Entertainment</h3>
	<div id="EntScroll">
		<?php
			$myDB = mysql_connect('localhost', 'metube', 'SuperSecurePassword');
			mysql_select_db('metube');

			$id = "Entertainment";
			$sqlq = "SELECT name, description FROM media WHERE category='$id'";
			$result = mysql_query($sqlq);
			echo "<table>";
			while($col = mysql_fetch_array($result)){   //Creates a loop to loop through results
				echo "<td><tr>" . $col['name'] . "</tr><tr>" . $col['description'] . "</tr></td>";  //$col['index'] the index here is a field name
			}

			echo "</table>";
			mysql_close($myDB);
			
		?></div>
	<h3>Gaming</h3>
	<div id="GamScroll">
	<?php
	
			$myDB = mysql_connect('localhost', 'metube', 'SuperSecurePassword');
			mysql_select_db('metube');

			$id = "Gaming";
			$sqlq = "SELECT name, description FROM media WHERE category='$id'";
			$result = mysql_query($sqlq);
			echo "<table>";
			while($col = mysql_fetch_array($result)){   //Creates a loop to loop through results
				echo "<td><tr>" . $col['name'] . "</tr><tr>" . $col['description'] . "</tr></td>";  //$col['index'] the index here is a field name
			}

			echo "</table>";
			mysql_close($myDB);
			
		?></div>
	<h3>Sports</h3>
	<div id="SpoScroll">
	<?php
			$myDB = mysql_connect('localhost', 'metube', 'SuperSecurePassword');
			mysql_select_db('metube');

			$id = "Sports";
			$sqlq = "SELECT name, description FROM media WHERE category='$id'";
			$result = mysql_query($sqlq);
			echo "<table>";
			while($col = mysql_fetch_array($result)){   //Creates a loop to loop through results
				echo "<td><tr>" . $col['name'] . "</tr><tr>" . $col['description'] . "</tr></td>";  //$col['index'] the index here is a field name
			}

			echo "</table>";
			mysql_close($myDB);
			
		?></div>
	<h3>Music</h3>
	<div id="MusScroll">
	<?php
			$myDB = mysql_connect('localhost', 'metube', 'SuperSecurePassword');
			mysql_select_db('metube');

			$id = "Music";
			$sqlq = "SELECT name, description FROM media WHERE category='$id'";
			$result = mysql_query($sqlq);
			echo "<table>";
			while($col = mysql_fetch_array($result)){   //Creates a loop to loop through results
				echo "<td><tr>" . $col['name'] . "</tr><tr>" . $col['description'] . "</tr></td>";  //$col['index'] the index here is a field name
			}

			echo "</table>";
			mysql_close($myDB);
			
		?></div>
	<h3>Movies</h3>
	<div id="MovScroll">
	<?php
			$myDB = mysql_connect('localhost', 'metube', 'SuperSecurePassword');
			mysql_select_db('metube');

			$id = "Movies";
			$sqlq = "SELECT name, description FROM media WHERE category='$id'";
			$result = mysql_query($sqlq);
			echo "<table>";
			while($col = mysql_fetch_array($result)){   //Creates a loop to loop through results
				echo "<td><tr>" . $col['name'] . "</tr><tr>" . $col['description'] . "</tr></td>";  //$col['index'] the index here is a field name
			}

			echo "</table>";
			mysql_close($myDB);
			
		?></div>
	<h3>TV Shows</h3>
	<div id="ShoScroll"><?php
			$myDB = mysql_connect('localhost', 'metube', 'SuperSecurePassword');
			mysql_select_db('metube');

			$id = "TV Shows";
			$sqlq = "SELECT name, description FROM media WHERE category='$id'";
			$result = mysql_query($sqlq);
			echo "<table>";
			while($col = mysql_fetch_array($result)){   //Creates a loop to loop through results
				echo "<td><tr>" . $col['name'] . "</tr><tr>" . $col['description'] . "</tr></td>";  //$col['index'] the index here is a field name
			}

			echo "</table>";
			mysql_close($myDB);
			
		?></div>
	<h3>News</h3>
	<div id="NewScroll">
	<?php
			$myDB = mysql_connect('localhost', 'metube', 'SuperSecurePassword');
			mysql_select_db('metube');

			$id = "News";
			$sqlq = "SELECT name, description FROM media WHERE category='$id'";
			$result = mysql_query($sqlq);
			echo "<table>";
			while($col = mysql_fetch_array($result)){   //Creates a loop to loop through results
				echo "<td><tr>" . $col['name'] . "</tr><tr>" . $col['description'] . "</tr></td>";  //$col['index'] the index here is a field name
			}

			echo "</table>";
			mysql_close($myDB);
			
		?></div>
	<h3>Spotlight</h3>
	<div id="SpotScroll">
	<?php
			$myDB = mysql_connect('localhost', 'metube', 'SuperSecurePassword');
			mysql_select_db('metube');

			$id = "Spotlight";
			$sqlq = "SELECT name, description FROM media WHERE category='$id'";
			$result = mysql_query($sqlq);
			echo "<table>";
			while($col = mysql_fetch_array($result)){   //Creates a loop to loop through results
				echo "<td><tr>" . $col['name'] . "</tr><tr>" . $col['description'] . "</tr></td>";  //$col['index'] the index here is a field name
			}

			echo "</table>";
			mysql_close($myDB);
			
		?></div>
</body>
</html>
