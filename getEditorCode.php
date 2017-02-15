<?php
session_start();
$level = $_SESSION['level'];
// Load default file
	echo 'js/levels/'.$level.'/level'.$level.'.js';
?>