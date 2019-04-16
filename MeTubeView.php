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
	include_once "function.php";?>



	<div id="video">
		<?php
		if ( isset( $_GET[ 'id' ] ) ) {
			$query = "SELECT * FROM media WHERE id='" . $_GET[ 'id' ] . "'";
			$result = mysql_query( $query );
			$result_row = mysql_fetch_row( $result );

			//updateMediaTime($_GET['id']);

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

		<object id="MediaPlayer" width=320 height=286 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components…" type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112">

<param name="filename" value="<?php echo $result_row[3].$result_row[2];  ?>">
<param name="Showcontrols" value="True">
<param name="autoStart" value="True">

<embed type="application/x-mplayer2" src="<?php echo $result_row[3].$result_row[2];  ?>" name="MediaPlayer" width=320 height=240></embed>

</object>

	
		<?php } 
	$tags = mysql_query("SELECT * FROM mediatags WHERE mediaid=".$result_row[0]); 
	$tag = mysql_fetch_row($tags); 
	$username = mysql_fetch_row(mysql_query("SELECT name FROM users WHERE id = ".$result_row[1]));
	?>
		<br> User:
		<?php echo $username[0]; ?>
		<?php 
		if (isset($_SESSION['userID'])) {
			$fav = mysql_query("SELECT COUNT(*) FROM subscribers WHERE channelid=".$result_row[1]." AND userid=".$_SESSION['userID']);
			$faved = mysql_fetch_array($fav);
			
		if ($faved[0] == 0) { ?>
		<form class="subscribe" action="operation.php" method="post">
			<input type="hidden" name="mediaid" value=<?php echo '"' . $result_row[0] . '"'; ?>/>
			<input type="hidden" name="channelid" value=<?php echo '"' . $result_row[1] . '"'; ?>/>
			<input type="hidden" name="action" value="subscribe"/>
			<input value="Subscribe" name="submit" type="submit"/>
		</form>
		<?php } else { ?>
		<form class="subscribe" action="operation.php" method="post">
			<input type="hidden" name="mediaid" value=<?php echo '"' . $result_row[0] . '"'; ?>/>
			<input type="hidden" name="channelid" value=<?php echo '"' . $result_row[1] . '"'; ?>/>
			<input type="hidden" name="action" value="unsubscribe"/>
			<input value="Unsubscribe" name="submit" type="submit"/>
		</form>


		<?php } } ?>


		<br> Description:
		<?php echo $result_row[6]; ?> <br> Tags:

		<?php echo '<a href="MeTubeSearch.php?q='.$tag[1].'">'.$tag[1].'</a>'; while ($tag = mysql_fetch_row($tags)) { echo ', '.'<a href="MeTubeSearch.php?q='.$tag[1].'">'.$tag[1].'</a>'; } ?> <br> Category:
		<?php echo '<a href="MeTubeSearch.php?q='.$result_row[7].'">'.$result_row[7].'</a>'; ?> <br>
		<?php if($result_row[1] == $_SESSION['userID']) { 
	$tags = mysql_query("SELECT * FROM mediatags WHERE mediaid=".$result_row[0]); 
	$tag = mysql_fetch_row($tags); ?>
		<?php 
		if (isset($_SESSION['userID'])) {
			$fav = mysql_query("SELECT COUNT(*) FROM favorites WHERE mediaid=".$result_row[0]." AND userid=".$_SESSION['userID']);
			$faved = mysql_fetch_array($fav);
			
		if ($faved[0] == 0) { ?>
		<form class="favorite" action="operation.php" method="post">
			<input type="hidden" name="mediaid" value=<?php echo '"' . $result_row[0] . '"'; ?>/>
			<input type="hidden" name="action" value="favadd"/>
			<input value="Favorite" name="submit" type="submit"/>
		</form>
		<?php } else { ?>
		<form class="favorite" action="operation.php" method="post">
			<input type="hidden" name="mediaid" value=<?php echo '"' . $result_row[0] . '"'; ?>/>
			<input type="hidden" name="action" value="favdel"/>
			<input value="Unfavorite" name="submit" type="submit"/>
		</form>


		<?php } } ?>


		<h3>Edit Metadata</h3>
		<form class="metadata" action="operation.php" method="post">
			Description:<br>
			<textarea name="description" rows="4" cols="30"><?php echo $result_row[6]; ?></textarea><br> Tags (comma-separated):<br>
			<textarea name="tags" rows="4" cols="30"><?php echo $tag[1]; while ($tag = mysql_fetch_row($tags)) { echo ', '.$tag[1]; } ?></textarea><br> Category:
			<br>
			<select name="category">
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

		<?php }?>




		<?php }
else
{
?>
		<!--<meta http-equiv="refresh" content="0;url=MeTube.php"> -->
		<?php
		}
		?>
	</div>

	<?php if($result_row[8] != 1) {
	echo "<h2>Comments are disabled for this media</h2>";
} else { ?>
	<div id="comments">
		<h2>Comments</h2>
		<?php if (isset($_SESSION['userID'])) { ?>
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
			while ( $result_row = mysql_fetch_row( $result ) ) {
				?>
			<tr>
				<td>
					<b>
						<?php echo '<a href="MeTubeAccount.php?id='.$result_row[2].'">'.$result_row[0].'</a>: '; ?>
					</b>
					<?php echo $result_row[1]; 
					if($result_row[2] == $_SESSION['userID']) {?>
					<form class="delcomment" action="operation.php" method="post">
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
	<?php } ?>
</body>
</html>