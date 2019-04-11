<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MeTube/Create</title>
<link rel="stylesheet" type="text/css" href="../MeTube.css"> 
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; ?>
	<form class="upload" action="media_upload_process.php" method="post" enctype="multipart/form-data" align="center"><!-- Links to PHP file for signing in. -->
  <p style="margin:0; padding:0">
	  Title <input type="text" name="title" required><br><br>
  <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
   Upload a file: <label style="color:#663399"><em> (Max file size 10 MB)</em></label><br/>
   <input  name="file" type="file" size="50" required/>
  
	<input value="Upload" name="submit" type="submit" />
  </p>
	</form>
	<p align="center" style="font-size: 13px">Already have an account? Click <a href="../MeTubeSignIn.dwt">here</a> to got to it.</p>
</body>
</html>
