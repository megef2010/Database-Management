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
	$desc = mysql_real_escape_string($_POST['description']);
	$userid = $_SESSION['userID'];
	$id = mysql_real_escape_string($_POST['mediaid']);
	$category = mysql_real_escape_string($_POST['category']);
	$allowcomments = 0;
	if($_POST['allowcomments'] == "TRUE") { $allowcomments = 1; }
	$query = "UPDATE media SET description='$desc', category='$category', allow_comments='$allowcomments' WHERE id='$id' AND userid='$userid'";
	mysql_query($query);
	$tags = explode(', ', $_POST['tags']);
	
	mysql_query("DELETE FROM mediatags WHERE mediaid='$id'");
	
	foreach ($tags as $tag) {
		$tag = mysql_real_escape_string($tag);
		mysql_query("INSERT INTO mediatags (mediaid, tag) VALUES ('$id', '$tag')");
		
	}
	
}?>


<meta http-equiv="refresh" content="0;url=MeTubeView.php?id=<?php echo $id; ?>">