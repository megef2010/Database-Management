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
   
   <?php
    $mes=$_POST['message'];
    $senderid=mysql_query("SELECT sendid FROM messages WHERE id=$mes");
    $sender=mysql_query("SELECT name FROM user WHERE id=$senderid");?>
    <h2><?php echo '$sender';?>'s Message.</h2><br><br>
   <?php
    $oldmessage=mysql_query("SELECT text FROM messages WHERE id=$mes");
    echo '$oldmessage';
   ?><br><br>
   
   <h2>Reply</h2><br><br>
   <div id="newMessage">
   <form class="newMessage" action="operation.php" method="post">
    <input type="text" name="to" value="<?php echo $sender;?>"><br><br>
    <textarea name="messagebody">Your message here...</textarea><br><br>
	   <input type="hidden" name="action" value="message"/>
    <input type="submit" value="Send">
   </form>
   </div>
</body>
</html>
