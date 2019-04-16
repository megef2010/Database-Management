<?php
session_name( 'MetubeSession' );
session_start();
include_once "function.php";

/******************************************************
 *
 * comment from user
 *
 *******************************************************/
$redirect = 'MeTube.php'; // at least a plurality of redirects go to the homepage so it's the default

if ( isset( $_POST[ 'action' ] ) ) {
	switch ( $_POST[ 'action' ] ) {
		case 'signin':
			$username = mysql_real_escape_string( $_POST[ 'email' ] );
			$password = md5( $_POST[ 'password' ] );

			$result = mysql_fetch_array( mysql_query( "SELECT COUNT(*) FROM users WHERE name = '$username' AND password = '$password'" ) );

			if ( $result[ 0 ] !== '1' ) {
				session_unset();
				session_destroy();
				$redirect = 'MeTubeSignIn.php?err=1';
				break;
			}

			$results = mysql_fetch_array( mysql_query( "SELECT id, name FROM users WHERE name='$username'" ) );

			$_SESSION[ 'username' ] = $results[ 1 ];
			$_SESSION[ 'userID' ] = $results[ 0 ];
			break;
		case 'signout':
			session_destroy();
			break;
		case 'create':
			$username = mysql_real_escape_string( $_POST[ 'email' ] );
			$password = md5( $_POST[ 'password' ] );
			$description = mysql_real_escape_string( $_POST[ 'description' ] );

			$result = mysqli_fetch_array( mysql_query( "SELECT COUNT(*) FROM users WHERE name = '$username'" ) );

			if ( $result[ 0 ] !== '0' ) {
				session_unset();
				session_destroy();
				header( 'Location: MeTubeCreate.html?errorMessage="Email Taken"', true, 302 );
				break;
			}

			mysql_query( "INSERT INTO users (name, password, description) VALUES ('$username', '$password', '$description')" );
			break;
		case 'media_upload':
			// todo: die if no username, die if no title, die if no file
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$username = $_SESSION[ 'username' ];

				//Create Directory if doesn't exist
				if ( !file_exists( 'uploads/' ) )
					mkdir( 'uploads/', 0744 );
				$dirfile = 'uploads/' . $username . '/';
				if ( !file_exists( $dirfile ) )
					mkdir( $dirfile, 0744 );


				if ( $_FILES[ "file" ][ "error" ] > 0 ) {
					$result = $_FILES[ "file" ][ "error" ];
				} //error from 1-4
				else {
					$upfile = $dirfile . urlencode( $_FILES[ "file" ][ "name" ] );

					if ( file_exists( $upfile ) ) {
						$result = "5"; //The file has been uploaded.
					} else {
						if ( is_uploaded_file( $_FILES[ "file" ][ "tmp_name" ] ) ) {
							if ( !move_uploaded_file( $_FILES[ "file" ][ "tmp_name" ], $upfile ) ) {
								$result = "6"; //Failed to move file from temporary directory
							} else /*Successfully upload file*/ {
								$title = $_POST[ 'title' ];
								//insert into media table
								$insert = "INSERT INTO media (userid, filename, filepath, type, title) VALUES (" . $_SESSION[ 'userID' ] . ", '" . urlencode( $_FILES[ "file" ][ "name" ] ) . "', '$dirfile', '" . $_FILES[ "file" ][ "type" ] . "', '$title')";

								echo $insert . "\n";

								$queryresult = mysql_query( $insert )
								or die( "Insert into Media error in media_upload_process.php " . mysql_error() );
								$result = "0";

								$mediaid = mysql_insert_id();
							}
						} else {
							$result = "7"; //upload file failed
						}
					}
				}
			}
			$redirect = "MeTube.php?result=".$result;
			break;
		case 'metadata':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$desc = mysql_real_escape_string( $_POST[ 'description' ] );
				$userid = $_SESSION[ 'userID' ];
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );
				$category = mysql_real_escape_string( $_POST[ 'category' ] );
				$allowcomments = 0;
				if ( $_POST[ 'allowcomments' ] == "TRUE" ) {
					$allowcomments = 1;
				}
				$query = "UPDATE media SET description='$desc', category='$category', allow_comments='$allowcomments' WHERE id='$mediaid' AND userid='$userid'";
				mysql_query( $query );
				$tags = explode( ', ', $_POST[ 'tags' ] );

				mysql_query( "DELETE FROM mediatags WHERE mediaid='$mediaid'" );

				foreach ( $tags as $tag ) {
					$tag = mysql_real_escape_string( $tag );
					mysql_query( "INSERT INTO mediatags (mediaid, tag) VALUES ('$mediaid', '$tag')" );
				}
			}
			$redirect = "MeTubeView.php?id=".$mediaid;
			break;
		case 'favadd':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$userid = $_SESSION[ 'userID' ];
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );

				mysql_query( "INSERT INTO favorites (userid, mediaid) VALUES ('$userid', '$mediaid')" );
			}
			$redirect = "MeTubeView.php?id=".$mediaid;
			break;
		case 'favdel':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$userid = $_SESSION[ 'userID' ];
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );

				mysql_query( "DELETE FROM favorites WHERE userid='$userid' AND mediaid='$mediaid'" );
			}
			$redirect = "MeTubeView.php?id=".$mediaid;
			break;
		case 'comment':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );
				$userid = $_SESSION[ 'userID' ];
				$comment = mysql_real_escape_string( $_POST[ 'comment' ] );

				mysql_query( "INSERT INTO comments (mediaid, userid, text) VALUES ('$mediaid', '$userid' ,'$comment')" );
			}
			$redirect = "MeTubeView.php?id=".$mediaid;
			break;
		case 'delcomment':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$commentid = mysql_real_escape_string( $_POST[ 'commentid' ] );
				$userid = $_SESSION[ 'userID' ];
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );

				mysql_query( "DELETE FROM comments WHERE id = '$commentid' AND userid = '$userid'" );
			}
			$redirect = "MeTubeView.php?id=".$mediaid;
			break;
		case 'profile':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$desc = mysql_real_escape_string( $_POST[ 'description' ] );
				$userid = $_SESSION[ 'userID' ];

				mysql_query( "UPDATE users SET description='$desc' WHERE id='$userid'" );
			}
			$redirect = "MeTubeAccount.php?id=".$userid;
			break;
		case 'subscribe':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$channelid = mysql_real_escape_string( $_POST[ 'channelid' ] );
				$userid = $_SESSION[ 'userID' ];
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );

				mysql_query( "INSERT INTO subscribers (userid, channelid) VALUES ('$userid', '$channelid')" );
			}
			$redirect = "MeTubeView.php?id=".$mediaid;
			break;
		case 'unsubscribe':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$channelid = mysql_real_escape_string( $_POST[ 'channelid' ] );
				$userid = $_SESSION[ 'userID' ];
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );

				mysql_query( "DELETE FROM subscribers WHERE userid='$userid' AND channelid='$channelid'" );
			}
			$redirect = "MeTubeView.php?id=".$mediaid;
			break;
		case 'message':
			// todo: error handling if no userid found
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$sender = $_SESSION[ 'userID' ];
				$receiver = mysql_real_escape_string( $_POST[ 'to' ] );
				$message = mysql_real_escape_string( $_POST[ '$messagebody' ] );
				$receiverid = mysql_query( "SELECT id FROM user WHERE name='$receiver'" );

				mysql_query( "INSERT INTO messages (sendid, recvid, text) VALUES ('$sender', '$receiverid', '$message')" );
			}
			$redirect = "MeTubeAccount.php?id=".$sender;
			break;
		default:
			$redirect = 'MeTube.php';
	}
} else {
	$redirect = 'MeTube.php';
}
header('Location: '.$redirect, true, 302);
?>