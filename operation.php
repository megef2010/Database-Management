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
			$username = mysql_real_escape_string( $_POST[ 'username' ] );
			$password = md5( $_POST[ 'password' ] );

			$result = mysql_fetch_array( mysql_query( "SELECT COUNT(*) FROM users WHERE name = '$username' AND password = '$password'" ) );

			if ( $result[ 0 ] != '1' ) {
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
			$username = mysql_real_escape_string( $_POST[ 'username' ] );
			$password = md5( $_POST[ 'password' ] );
			$conpass = md5( $_POST[ 'conpassword' ] );
			$description = mysql_real_escape_string( $_POST[ 'description' ] );
			
			if ( $password == $conpass ) {
				$result = mysql_fetch_array( mysql_query( "SELECT COUNT(*) FROM users WHERE name = '$username'" ) );
			
				if ( $result[ 0 ] == '1' ) {
					$redirect = 'MeTubeCreate.php?err=1';
					break;
				}
				mysql_query( "INSERT INTO users (name, password, description) VALUES ('$username', '$password', '$description')" );
				break;
			}
			else {
				$redirect = 'MeTubeCreate.php?err=2';
				break;	
			}
			
		case 'media_upload':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$username = $_SESSION[ 'username' ];

				//Create Directory if doesn't exist
				if ( !file_exists( 'uploads/' ) ) {
					mkdir( 'uploads/' );
					chmod( 'uploads/', 0755 );
				}

				$dirfile = 'uploads/' . $username . '/';
				if ( !file_exists( $dirfile ) ) {
					mkdir( $dirfile, 0755 );
					chmod( $dirfile, 0755 );
				}

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
								chmod( $upfile, 0655 );
								$mediaid = mysql_insert_id();
							}
						} else {
							$result = "7"; //upload file failed
						}
					}
				}
			}
			$redirect = "MeTube.php?result=" . $result;
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
			$redirect = "MeTubeView.php?id=" . $mediaid;
			break;
		case 'favadd':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$userid = $_SESSION[ 'userID' ];
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );

				mysql_query( "INSERT INTO favorites (userid, mediaid) VALUES ('$userid', '$mediaid')" );
			}
			$redirect = "MeTubeView.php?id=" . $mediaid;
			break;
		case 'favdel':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$userid = $_SESSION[ 'userID' ];
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );

				mysql_query( "DELETE FROM favorites WHERE userid='$userid' AND mediaid='$mediaid'" );
			}
			$redirect = "MeTubeView.php?id=" . $mediaid;
			break;
		case 'comment':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );
				$userid = $_SESSION[ 'userID' ];
				$comment = mysql_real_escape_string( $_POST[ 'comment' ] );

				mysql_query( "INSERT INTO comments (mediaid, userid, text) VALUES ('$mediaid', '$userid' ,'$comment')" );
			}
			$redirect = "MeTubeView.php?id=" . $mediaid;
			break;
		case 'delcomment':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$commentid = mysql_real_escape_string( $_POST[ 'commentid' ] );
				$userid = $_SESSION[ 'userID' ];
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );

				mysql_query( "DELETE FROM comments WHERE id = '$commentid' AND userid = '$userid'" );
			}
			$redirect = "MeTubeView.php?id=" . $mediaid;
			break;
		case 'profile':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$desc = mysql_real_escape_string( $_POST[ 'description' ] );
				$userid = $_SESSION[ 'userID' ];

				mysql_query( "UPDATE users SET description='$desc' WHERE id='$userid'" );
			}
			$redirect = "MeTubeAccount.php?id=" . $userid;
			break;
		case 'subscribe':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$channelid = mysql_real_escape_string( $_POST[ 'channelid' ] );
				$userid = $_SESSION[ 'userID' ];
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );

				mysql_query( "INSERT INTO subscribers (userid, channelid) VALUES ('$userid', '$channelid')" );
			}
			$redirect = "MeTubeView.php?id=" . $mediaid;
			break;
		case 'unsubscribe':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$channelid = mysql_real_escape_string( $_POST[ 'channelid' ] );
				$userid = $_SESSION[ 'userID' ];
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );

				mysql_query( "DELETE FROM subscribers WHERE userid='$userid' AND channelid='$channelid'" );
			}
			$redirect = "MeTubeView.php?id=" . $mediaid;
			break;
		case 'message':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$sender = $_SESSION[ 'userID' ];
				$receiver = mysql_real_escape_string( $_POST[ 'to' ] );
				$subject = mysql_real_escape_string( $_POST[ 'subject' ] );
				$message = mysql_real_escape_string( $_POST[ 'messagebody' ] );
				$receiverid = mysql_fetch_row(mysql_query( "SELECT id FROM users WHERE name='$receiver'" ));
				$receiverid = $receiverid[0];
				
				mysql_query( "INSERT INTO messages (sendid, recvid, text, subject) VALUES ('$sender', '$receiverid', '$message', '$subject')" );
			}
			$redirect = "MeTubeAccount.php?id=" . $sender;
			break;
		case 'playlistcreate':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$userid = $_SESSION[ 'userID' ];
				$name = mysql_real_escape_string( $_POST[ 'playlist' ] );

				mysql_query( "INSERT INTO playlists (userid, name) VALUES ('$userid', '$name')" );
			}
			$redirect = "MeTubePlaylist.php";
			break;
		case 'playlistdelete':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$userid = $_SESSION[ 'userID' ];
				$id = mysql_real_escape_string( $_POST[ 'playlistid' ] );

				mysql_query( "DELETE FROM playlists WHERE userid='$userid' AND id='$id'" );
			}
			$redirect = "MeTubePlaylist.php";
			break;
		case 'playlistadd':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$userid = $_SESSION[ 'userID' ];
				$playlistid = mysql_real_escape_string( $_POST[ 'playlist' ] );
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );
				if (mysql_result(mysql_query("SELECT COUNT(*) FROM playlists WHERE id='$playlistid' AND userid='$userid'"),0) != 0)
					mysql_query( "INSERT INTO playlistcontent (playlistid, mediaid) VALUES ('$playlistid', '$mediaid')" );
			}
			$redirect = "MeTubeView.php?id=" . $mediaid;
			break;
		case 'playlistrem':
			if ( isset( $_SESSION[ 'userID' ] ) ) {
				$userid = $_SESSION[ 'userID' ];
				$playlistid = mysql_real_escape_string( $_POST[ 'playlist' ] );
				$mediaid = mysql_real_escape_string( $_POST[ 'mediaid' ] );
				if (mysql_result(mysql_query("SELECT COUNT(*) FROM playlists WHERE id='$playlistid' AND userid='$userid'"),0) != 0) 
					mysql_query( "DELETE FROM playlistcontent WHERE playlistid='$playlistid' AND mediaid='$mediaid'" ); 
			}
			$redirect = "MeTubePlaylist.php?id=" . $playlistid;
			break;
		case 'newpass':
			$password = md5( $_POST[ 'password' ] );
			$conpass = md5( $_POST[ 'conpassword' ] );
			
			if ( $password == $conpass ) {
				
				if ( isset( $_SESSION[ 'userID' ] ) ) {
					$userid = $_SESSION[ 'userID' ];
					mysql_query("UPDATE user SET password= '$password' WHERE id = '$userid'");
					$redirect = 'MeTubeChangePassword.php?err=2';
				}
				break;
			}
			else {
				$redirect = 'MeTubeChangePassword.php?err=1';
				break;
			}
		case 'addcontacts':
			$contact = $_POST[ 'contact' ];
			$user = $_SESSION[ 'userID' ];
			mysql_query("INSERT INTO usercontacts (userid, contactid) VALUES ('$user', '$contact')");
			$redirect = 'MeTubeAccount.php?id='.$contact;
			break;
		case 'removecontacts':
			$contact = $_POST[ 'contact' ];
			$user = $_SESSION[ 'userID' ];
			mysql_query("DELETE FROM usercontacts WHERE userid='$user' AND contactid='$contact'");
			$redirect = 'MeTubeAccount.php?id='.$contact;
			break;
		default:
			$redirect = 'MeTube.php';
	}
} else {
	$redirect = 'MeTube.php';
}
if(isset($_POST['redir']))
	$redirect = $_POST['redir'];
header( 'Location: ' . $redirect, true, 302 );
?>
