<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>MeTube</title>
	<link rel="stylesheet" type="text/css" href="MeTube.css">
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php';
		include_once 'function.php';?>
	<!-- Template for Homepage. Horizontal scrollbar with videos displayed under each category title. -->
	<h2>Best of MeTube</h2>

	<?php
	printcategorybox( "Politics" );
	printcategorybox( "Entertainment" );
	printcategorybox( "Gaming" );
	printcategorybox( "Sports" );
	printcategorybox( "Music" );
	printcategorybox( "Movies" );
	printcategorybox( "TV Shows" );
	printcategorybox( "News" );
	printcategorybox( "Spotlight" );
	?>

</body>
</html>