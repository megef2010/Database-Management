<?php

$connect = new mysqli('localhost', 'metube', 'SuperSecurePassword', 'metube');
if($connect->connect_error)
{
	die("Something didnt work: " . $connect->connect_error);
}
echo "It worked";

?>