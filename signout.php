	<?php
	session_name('MetubeSession');
	session_start();
	session_destroy();
	echo '<meta http-equiv="refresh" content="0;url=MeTube.php">';
	exit();
?>

