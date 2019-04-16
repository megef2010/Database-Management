<?php
session_name( 'MetubeSession' );
session_start();
include_once 'function.php';
?>
<style type="text/css">
	.header {
		height: 100px;
		display: block;
		position: relative;
	}
	
	.logo {
		line-height: 0px;
		float: left;
	}
	
	.searchbar {
		line-height: 50px;
		float: left;
	}
	
	.account {
		float: right;
		line-height: 50px;
	}
</style>




<div class="header"><span class="logo"><h1><a href="MeTube.php">MeTube</a></h1></span>
	<span class="searchbar">
		<form class="search" action="MeTubeSearch.php" method="post"><input type="text" placeholder=<?php echo "\"".@$_GET['q']."\""?> name="searchbar">
			<button type="submit">
			<i class="fa fa-search">Search</i></button>
		</form>
	</span>
	<span class="account">
		<?php 
	if (isset($_SESSION['username']))
	{
		echo 'Welcome, ' . $_SESSION['username'] . ' | ';
		echo '<a href="/MeTubeUpload.php">Upload</a> | ';
		echo '<a href="MeTubeAccount.php?id=' . $_SESSION['userID'] . '">Go To Account</a> | ';
		?> 
		<form class="signin" action="operation.php" align="center" method="post" style="display: inline-block">
			<input type="hidden" name="action" value="signout"/>
			<input type="submit" value="Sign Out">
		</form>
		<?php
		} else {
			echo '<a href="/MeTubeSignIn.php">Sign In</a> | <a href="/MeTubeCreate.php">Create an Account</a>';

		}
		?>
	</span>

</div>