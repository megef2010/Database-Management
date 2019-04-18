<?php
include "mysqlClass.inc.php";

function user_pass_check( $username, $password ) {

	$query = "SELECT * FROM users WHERE name='$username'";
	$result = mysql_query( $query );

	if ( !$result ) {
		die( "user_pass_check() failed. Could not query the database: <br />" . mysql_error() );
	} else {
		$row = mysql_fetch_row( $result );
		if ( strcmp( $row[ 1 ], $password ) )
			return 2; //wrong password
		else
			return 0; //Checked.
	}
}

function updateMediaTime( $mediaid ) {
	$query = "	update  media set lastaccesstime=NOW()
   						WHERE '$mediaid' = mediaid
					";
	// Run the query created above on the database through the connection
	$result = mysql_query( $query );
	if ( !$result ) {
		die( "updateMediaTime() failed. Could not query the database: <br />" . mysql_error() );
	}
}

function upload_error( $result ) {
	//view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ( $result ) {
		case 1:
			return "UPLOAD_ERR_INI_SIZE";
		case 2:
			return "UPLOAD_ERR_FORM_SIZE";
		case 3:
			return "UPLOAD_ERR_PARTIAL";
		case 4:
			return "UPLOAD_ERR_NO_FILE";
		case 5:
			return "File has already been uploaded";
		case 6:
			return "Failed to move file from temporary directory";
		case 7:
			return "Upload file failed";
	}
}

function printcategorybox( $category ) {
	if($category == NULL) {
		echo "<h3>Uncategorized</h3>";
		$sqlq = "SELECT id, title, description FROM media WHERE (category='' OR category IS NULL)";
	} else {
		echo "<h3>".$category."</h3>";
		$sqlq = "SELECT id, title, description FROM media WHERE category='$category'";
	}
	echo '<div id="CategoryScroll">';
	;
	if ( $result = mysql_query( $sqlq ) ) {
		echo "<table>";
		while ( $col = mysql_fetch_row( $result ) ) { //Creates a loop to loop through results
			echo "<tr><td><a href=\"MeTubeView.php?id=" . $col[0] . "\">" . $col[1] . "</a></td></tr><tr><td>" . $col[2] . "</td></tr>"; //$col['index'] the index here is a field name
		}

		echo "</table>";
	}
	echo "</div>";
}

function isowner( $type, $id ) {
	mysql_real_escape_string($id);
	switch($type) {
		case 'account':
			return $id == $_SESSION['userID'];
		case 'message':
			$result = mysql_result(mysql_query("SELECT recvid FROM messages WHERE id=" . $id),0);
			return $result == $_SESSION['userID'];
		case 'playlist':
			$result = mysql_result(mysql_query("SELECT userid FROM playlists WHERE id=" . $id),0);
			return $result == $_SESSION['userID'];
		case 'media':
			$result = mysql_result(mysql_query("SELECT userid FROM media WHERE id=" . $id),0);
			return $result == $_SESSION['userID'];
		case 'comment':
			$result = mysql_result(mysql_query("SELECT userid FROM comments WHERE id=" . $id),0);
			return $result == $_SESSION['userID'];
		default:
			return false;
				
	}
}
//Check if user is signed in.
// Returns true if signed in.
// If $redirect = true redirect to login page if not signed in.
function isloggedin($redirect)
{
	if(isset($_SESSION['userID']))
	{
		return true;
	} else if ($redirect) {
		header( 'Location: MeTubeSignIn.php' , true, 302 );
	}
	return false;
}


?>