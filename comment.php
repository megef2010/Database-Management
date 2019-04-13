<?php
session_name('MetubeSession');
session_start();
include_once "function.php";

/******************************************************
*
* comment from user
*
*******************************************************/

if(isset($_SESSION['userID']))
{
	$comment = mysql_real_escape_string($_POST['comment']);
	$query = "INSERT INTO comments (mediaid, userid, text) VALUES (".$_POST['mediaid'].", ".$_SESSION['userID'].",'$comment')";
	mysql_query($query);
}?>


<meta http-equiv="refresh" content="0;url=MeTubeView.php?id=<?php echo $_POST['mediaid'];?>">