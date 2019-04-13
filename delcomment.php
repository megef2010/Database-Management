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
	$id = mysql_real_escape_string($_POST['commentid']);
	$userid = $_SESSION['userID'];
	$query = "DELETE FROM comments WHERE id = '$id' AND userid = '$userid'";
	mysql_query($query);
}?>


<meta http-equiv="refresh" content="0;url=MeTubeView.php?id=<?php echo $_POST['mediaid'];?>">