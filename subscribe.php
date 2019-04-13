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
	$channelid = mysql_real_escape_string($_POST['channelid']);
	$userid = $_SESSION['userID'];
	$action = mysql_real_escape_string($_POST['action']);
	$mediaid = mysql_real_escape_string($_POST['mediaid']);
	if($action == "add") {
		mysql_query("INSERT INTO subscribers (userid, channelid) VALUES ('$userid', '$channelid')");
	} else if($action == "del") {
		mysql_query("DELETE FROM subscribers WHERE userid='$userid' AND channelid='$channelid'");
	}
}?>


<meta http-equiv="refresh" content="0;url=MeTubeView.php?id=<?php echo $mediaid; ?>">