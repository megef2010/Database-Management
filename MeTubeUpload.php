<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>MeTube/Upload</title>
	<link rel="stylesheet" type="text/css" href="../MeTube.css">
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; 
	if(isloggedin(true)) { ?>
	<form class="upload" action="operation.php" method="post" enctype="multipart/form-data" align="center">
		<!-- Links to PHP file for signing in. -->
		<p style="margin:0; padding:0">
			Title <input type="text" name="title" required><br><br>
			<input type="hidden" name="MAX_FILE_SIZE" value="10485760"/> Upload a file (Max file size is 10 MB)<br/>
			<input name="file" type="file" size="50" required/>
			<input type="hidden" name="action" value="media_upload"/>
			<input value="Upload" name="submit" type="submit"/>
		</p>
	</form>
	<?php } ?>
</body>
</html>