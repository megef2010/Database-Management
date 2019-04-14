<!doctype html>

<html>
<head>
<meta charset="utf-8">
<title>MeTube/Search</title>
<link rel="stylesheet" type="text/css" href="MeTube.css"> 
</head>
<body>
	<?php include 'MeTube_GlobalHeader.php'; 
	include_once "function.php";
  
	if(isset($_GET['id'])) {
		$id = mysql_real_escape_string($_GET['id']);
		$result = mysql_query("SELECT name, description FROM users WHERE id='$id'" );
		$row = mysql_fetch_row($result);
	} 	
	else { 
		echo '<meta http-equiv="refresh" content="0;url=MeTube.php">';
	 } ?>
   
   <br><br>
   <h2>New Message</h2>
   
   <div id="newMessage">
   <form class="newMessage" action="sendnewmessage.php" method="post">
    <input type="text" name="to" value="To..."><br><br>
    <textarea name="messagebody">Your message here...</textarea><br><br>
    <input type="submit" value="Send">
   </form>
   </div>
   
</body>

</html>
