<?php

	function curPageURL() {
		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	}
	if ( session_id() !== $MeTubeSignedIn ) {
		echo '	<a href="MeTubeSignIn.html">Sign In</a>	';
		
	} else if ( curPageURL() == "MeTubeAccount.html") {
		if(isset($_GET['logout'])) {
			session_start();
			session_destroy();


			$logout = "SignIn.php";        

			echo '	<a href="Metube.html">Go to home.</a>		';
			exit();
		}
		echo 'Are you sure you want to log out?'. '\n';
		
		echo '<p>' . '\n';
		echo '    <a href="' . $_SERVER['SCRIPT_NAME'] . '?logout=1">Yes</a> | <a href="another_page.php">No</a>';
		echo '</p>' . '\n';
	} else {
		echo '	<a href="MeTubeAccount.php">Go to Account</a>	';	
	}

?>