<?php
	session_start();
	// Saves user solution to file
	if(!empty($_POST['data'])){
		$data = $_POST['data'];
		// Convert current level number to string
		$levelNumber = $_SESSION["level"];
		$levelFolder = "$levelNumber";
		// Creates new file (or overwrites old one) with path /js/levels/(levelnumber)/(username).js
		$file = fopen("js/levels/".$levelFolder."/".$_SESSION['loggedinUser'].".js", 'w');
		$_SESSION["update"] = "true";
		fwrite($file, $data);
		fclose($file);
	}
?>
