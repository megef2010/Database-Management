<?php
session_name('MetubeSession');
session_start();
include_once "function.php";

/******************************************************
*
* upload document from user
*
*******************************************************/

// todo: die if no username, die if no title, die if no file

$username=$_SESSION['username'];

//Create Directory if doesn't exist
if(!file_exists('uploads/'))
	mkdir('uploads/', 0744);
$dirfile = 'uploads/'.$username.'/';
if(!file_exists($dirfile))
	mkdir($dirfile, 0744);


	if($_FILES["file"]["error"] > 0 )
	{ $result=$_FILES["file"]["error"];} //error from 1-4
	else
	{
	  $upfile = $dirfile.urlencode($_FILES["file"]["name"]);
	  
	  if(file_exists($upfile))
	  {
	  		$result="5"; //The file has been uploaded.
	  }
	  else{
			if(is_uploaded_file($_FILES["file"]["tmp_name"]))
			{
				if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
				{
					$result="6"; //Failed to move file from temporary directory
				}
				else /*Successfully upload file*/
				{
					$title = $_POST['title'];
					//insert into media table
					$insert = "INSERT INTO media (userid, filename, filepath, type, title) VALUES (" . $_SESSION['userID'] . ", '". urlencode($_FILES["file"]["name"]) . "', '$dirfile', '". $_FILES["file"]["type"]."', '$title')";
					
					echo $insert . "\n";
					
					$queryresult = mysql_query($insert)
						  or die("Insert into Media error in media_upload_process.php " .mysql_error());
					$result="0";
					
					$mediaid = mysql_insert_id();
				}
			}
			else  
			{
					$result="7"; //upload file failed
			}
		}
	}
	
	//You can process the error code of the $result here.
?>

<meta http-equiv="refresh" content="0;url=browse.php?result=<?php echo $result;?>">
