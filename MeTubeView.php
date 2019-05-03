<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>MeTube/View</title>
	<link rel="stylesheet" type="text/css" href="MeTube.css">
	<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body>
	<?php include 'MeTube_GlobalHeader.php'; 
	if (@mysql_result(mysql_query("SELECT COUNT(*) FROM media WHERE id=" . mysql_real_escape_string($_GET[ 'id' ])),0) == 0) {
		echo "Error: No media exists with that ID.";
	} else { ?>



	<div id="video">
		<?php
		if ( isset( $_GET[ 'id' ] ) ) {
			$query = "SELECT * FROM media WHERE id='" . mysql_real_escape_string( $_GET[ 'id' ] ) . "'";
			$result = mysql_query( $query );
			$result_row = mysql_fetch_row( $result );

			$filename = $result_row[ 2 ];
			$filepath = $result_row[ 3 ];
			$type = $result_row[ 4 ];
			if ( substr( $type, 0, 5 ) == "image" ) //view image
			{
				echo "Viewing Picture:";
				echo $result_row[ 3 ] . $result_row[ 2 ];
				echo "<img src='" . $filepath . $filename . "'/>";
			} else //view movie
			{
				?>
		<p>Viewing Video:
			<?php echo $result_row[3].$result_row[2];?>
		</p>
		<video width="480" height="360" controls>
			<source src="<?php echo $result_row[ 3 ] . $result_row[ 2 ]; ?>" type="<?php echo $result_row[4]; ?>">
		</video>


	




		<?php } 
	$tags = mysql_query("SELECT * FROM mediatags WHERE mediaid=".$result_row[0]); 
	$tag = mysql_fetch_row($tags); 
	$username = mysql_fetch_row(mysql_query("SELECT name FROM users WHERE id = ".$result_row[1]));
	?>
		<br>
		<span>
		<a href="<?php echo $result_row[3].$result_row[2];?>" style="display: inline-block" download>Download</a> | 
		<?php if (isloggedin(false)) { ?>
		<form class="subscribe" action="operation.php" method="post" style="display: inline-block">
			<input type="hidden" name="mediaid" value=<?php echo '"' . $result_row[0] . '"'; ?>/>
			<input type="hidden" name="channelid" value=<?php echo '"' . $result_row[1] . '"'; ?>/>
		<?php if (mysql_result(mysql_query("SELECT COUNT(*) FROM subscribers WHERE channelid=".$result_row[1]." AND userid=".$_SESSION['userID']),0) == 0) { ?>
			<input type="hidden" name="action" value="subscribe"/>
			<input value="Subscribe to <?php echo $username[0]; ?>" name="submit" type="submit"/>
		<?php } else { ?>
			<input type="hidden" name="action" value="unsubscribe"/>
			<input value="Unsubscribe from <?php echo $username[0]; ?>" name="submit" type="submit"/>
		<?php } ?> 
		</form> | 
		
		<form class="favorite" action="operation.php" method="post" style="display: inline-block">
			<input type="hidden" name="mediaid" value=<?php echo '"' . $result_row[0] . '"'; ?>/>
		<?php if (mysql_result(mysql_query("SELECT COUNT(*) FROM favorites WHERE mediaid=".$result_row[0]." AND userid=".$_SESSION['userID']),0) == 0) { ?>
			<input type="hidden" name="action" value="favadd"/>
			<input value="Favorite" name="submit" type="submit"/>
		<?php } else { ?>
			<input type="hidden" name="action" value="favdel"/>
			<input value="Unfavorite" name="submit" type="submit"/>
		<?php } ?>
		</form>	| 
		<form class="playlistadd" action="operation.php" method="post" style="display: inline-block">
			<select name="playlist" required>
				<option value="">Add to playlist...</option>
				<?php 
				if ($playlists = mysql_query("SELECT id, name FROM playlists WHERE userid=" . $_SESSION['userID'])) {
					while ($pl_row = mysql_fetch_row($playlists)) {
				?>
				<option value="<?php echo $pl_row[0]; ?>">
					<?php echo $pl_row[1]; ?>
				</option>
				<?php } } ?>
			</select>
			<input type="hidden" name="mediaid" value="<?php echo $result_row[0]; ?>"/>
			<input type="hidden" name="action" value="playlistadd"/>
			<input value="Add" name="submit" type="submit"/>
		</form>
		
		<?php } ?>
		
		
	</span>
	
		<br> User:
		<?php echo $username[0]; ?>
		<br> Description:
		<?php echo $result_row[6]; ?>
		<br> Tags:
		<?php echo '<a href="MeTubeSearch.php?q='.$tag[1].'">'.$tag[1].'</a>'; while ($tag = mysql_fetch_row($tags)) { echo ', '.'<a href="MeTubeSearch.php?q='.$tag[1].'">'.$tag[1].'</a>'; } ?>
		<br> Category:
		<?php echo '<a href="MeTubeSearch.php?q='.$result_row[7].'">'.$result_row[7].'</a>'; ?> <br>






		<?php if(isowner('media',$_GET['id'])) { ?>



		<h3>Edit Metadata</h3>
		<form class="metadata" action="operation.php" method="post">
			Description:<br>
			<textarea name="description" rows="4" cols="30"><?php echo $result_row[6]; ?></textarea><br> 
			Tags (comma-separated):<br>
			<textarea name="tags" rows="4" cols="30"><?php $tags = mysql_query("SELECT * FROM mediatags WHERE mediaid=".$result_row[0]); $tag = mysql_fetch_row($tags); echo $tag[1]; while ($tag = mysql_fetch_row($tags)) { echo ', '.$tag[1]; } ?></textarea><br> 
			Category: <select name="category">
				<option "">(no category)</option>
				<option "Politics" <?php if ($result_row[7]=='Politics' ) { echo 'selected'; } ?> >Politics</option>
				<option "Entertainment" <?php if ($result_row[7]=='Entertainment' ) { echo 'selected'; } ?> >Entertainment</option>
				<option "Gaming" <?php if ($result_row[7]=='Gaming' ) { echo 'selected'; } ?> >Gaming</option>
				<option "Sports" <?php if ($result_row[7]=='Sports' ) { echo 'selected'; } ?> >Sports</option>
				<option "Music" <?php if ($result_row[7]=='Music' ) { echo 'selected'; } ?> >Music</option>
				<option "Movies" <?php if ($result_row[7]=='Movies' ) { echo 'selected'; } ?> >Movies</option>
				<option "TV Shows" <?php if ($result_row[7]=='TV Shows' ) { echo 'selected'; } ?> >TV Shows</option>
				<option "News" <?php if ($result_row[7]=='News' ) { echo 'selected'; } ?> >News</option>
				<option "Spotlight" <?php if ($result_row[7]=='Spotlight' ) { echo 'selected'; } ?> >Spotlight</option>
			</select><br>
			<input type="checkbox" name="allowcomments" value="TRUE" <?php if($result_row[8]==1 ) { echo "checked"; }?> > Allow comments on this media <br>
			<input type="hidden" name="mediaid" value=<?php echo '"' . $_GET[ 'id'] . '"'; ?>/>
			<input type="hidden" name="action" value="metadata"/>
			<input value="Update Metadata" name="submit" type="submit"/>
		</form>

		<?php } } else { ?>
		<meta http-equiv="refresh" content="0;url=MeTube.php">
		<?php } ?>
	</div>

	<?php if($result_row[8] != 1) { ?>
	<h2>Comments are disabled for this media</h2>
	<?php } else { ?>
	<div id="comments">
		<h2>Comments</h2>
		<?php if (isloggedin(false)) { ?>
		<form class="comment" action="operation.php" method="post">
			<textarea name="comment" rows="4" cols="30">Write your comment here...</textarea><br>
			<input type="hidden" name="mediaid" value=<?php echo '"' . $_GET[ 'id'] . '"'; ?>/>
			<input type="hidden" name="action" value="comment"/>
			<input value="Comment" name="submit" type="submit"/>
		</form>
		<?php } ?>
		<table style="border: 1px solid black; width: 500px;">
			<?php
			$query = "SELECT users.name, comments.text, comments.userid, comments.id, comments.mediaid FROM comments INNER JOIN users ON comments.userid=users.id WHERE comments.mediaid=" . $_GET[ 'id' ];
			$result = mysql_query( $query );
			while ( $result_row = mysql_fetch_row( $result ) ) { ?>
			<tr>
				<td>
					<b>
						<?php echo '<a href="MeTubeAccount.php?id='.$result_row[2].'">'.$result_row[0].'</a>: '; ?>
					</b>
					<?php echo $result_row[1]; 
					if(isowner('comment',$result_row[3])) {?>
					<form class="delcomment" action="operation.php" method="post" style="display: inline-block">
						<input type="hidden" name="commentid" value=<?php echo '"' . $result_row[3] . '"'; ?>/>
						<input type="hidden" name="mediaid" value=<?php echo '"' . $result_row[4] . '"'; ?>/>
						<input type="hidden" name="action" value="delcomment"/>
						<input value="Delete" name="submit" type="submit"/>
					</form>

					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<?php } } ?>
</body>
</html>