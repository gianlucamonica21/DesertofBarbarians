<?php
session_start();
$level = $_SESSION['level'];
$user = $_SESSION['loggedinUser'];
if(file_exists("js/levels/".$level."/".$user.".js")) {
// Load user solution file
	echo 'js/levels/'.$level.'/'.$user.'.js';
} else {
// Load default file
	echo 'js/levels/'.$level.'/level'.$level.'.js';
}
?>