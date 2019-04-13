<?php
session_name('MetubeSession');
session_start();
include_once "function.php";

/******************************************************
*
* update user description
*
*******************************************************/

if(isset($_SESSION['userID']))
{
	$mediaid = mysql_real_escape_string($_POST['mediaid']);
	$userid = $_SESSION['userID'];
	$action = mysql_real_escape_string($_POST['action']);
	if($action == "add") {
		mysql_query("INSERT INTO favorites (userid, mediaid) VALUES ('$userid', '$mediaid')");
	} else if($action == "del") {
		mysql_query("DELETE FROM favorites WHERE userid='$userid' AND mediaid='$mediaid'");
	}
}?>


<meta http-equiv="refresh" content="0;url=MeTubeView.php?id=<?php echo $mediaid; ?>">