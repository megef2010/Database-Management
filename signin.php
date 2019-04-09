<?php
	session_start();
	session_name($MeTubeSignedIn);

	$myDB = new mysqli("mysql1.'http://metube-1223456.duckdns.org/'", "metube", "SuperSecurePassword");

	function getDB(){
		//file path to json file
		$dbpath = 'private/database.json';

		//load it
		$db = file_get_contents($dbpath);

		//if blank, use empty array, else json decode into array
		if($db === "" || $db === false){
			$db = Array();
		}else{
			$db = json_decode($db,true);
		}

		return $db;
	}

	function writeDB($db){
		//file path to json file
		$dbpath = 'private/database.json';

		//write it
		file_put_contents($dbpath, json_encode($db));
	}
	
	function saveUser($user){
		$db = getDB();

		//write obj into users array (db array)
		$db[$user['username']] = $user;

		//save to disk
		writeDB($db);

		return true;
	}

	function authUser($username,$password){
		$db = getDB();
		if(!isset($db[$username])){
			return "No User";
		}

		$password = $password.$db[$username]['salt'];
		$hash = hash("sha256", $password);

		if($hash !== $db[$username]['hash']){
			return "No Match";
		}

		return true;
	}


	$username = $_POST['email'];
	$password = $_POST['password'];

	
	if(authUser($username, $password) !== true){

		session_unset();
		session_destroy();
		header('Location: MeTubeSignIn.html?errorMessage="Incorrect Username or Password."', true, 302);
		exit();
	}
	
	$usernameSQL = $myDB->real_escape_string($username);
	$sql = "SELECT ID FROM SPONSORS WHERE EMAIL='$usernameSQL'";
	$results = $myDB->query($sql);
	$arr = $results->fetch_assoc();

	$id = $arr['ID'];

	$_SESSION['username'] = $username;
	$_SESSION['sponsorID'] = $id;
	echo '	<a href="MeTube.html">Go To Account</a>	';
	exit();
?>
