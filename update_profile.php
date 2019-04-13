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
	$id = $_SESSION['userID'];
	$query = "UPDATE users SET description='$desc' WHERE id='$id'";
	mysql_query($query);
}?>


<meta http-equiv="refresh" content="0;url=MeTubeAccount.php?id=<?php echo $id; ?>">