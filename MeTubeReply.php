<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MeTube/Reply</title>
<link rel="stylesheet" type="text/css" href="MeTube.css"> 
</head>
<body>

	<?php include 'MeTube_GlobalHeader.php'; 
	include_once "function.php";
	if(!isset($_GET['id'])) {
		echo '<meta http-equiv="refresh" content="0;url=MeTube.php">';
	 } ?>
   <br><br>
   <!-- todo: verify session user is receiver -->
   <?php
    $mes=$_GET['id'];
    $senderid=mysql_result(mysql_query("SELECT sendid FROM messages WHERE id=$mes"),0);
    $sender=mysql_result(mysql_query("SELECT name FROM users WHERE id=$senderid"),0);
	$subject=mysql_result(mysql_query("SELECT subject FROM messages WHERE id=$mes"),0);?>
    <h2><?php echo $sender;?>'s Message.</h2><br><br>
   <?php
   echo "<h4>".$subject."</h4>";
    echo mysql_result(mysql_query("SELECT text FROM messages WHERE id=$mes"),0);
   ?><br><br>
   
   <h2>Reply</h2><br><br>
   <div id="newMessage">
   <form class="newMessage" action="operation.php" method="post">
    <input type="text" name="to" value="<?php echo $sender;?>"><br><br>
	<input type="text" name="subject" value="Re: <?php echo $subject;?>"><br><br>
    <textarea name="messagebody" cols="40" rows="5" placeholder="Your message here"></textarea><br><br>
	   <input type="hidden" name="action" value="message"/>
    <input type="submit" value="Send">
   </form>
   </div>
</body>
</html>
