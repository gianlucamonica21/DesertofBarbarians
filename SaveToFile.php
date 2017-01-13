<?php
	session_start();
	if(!empty($_POST['data'])){
		$data = $_POST['data'];
		$fname = mktime() . ".txt";//generates random name
		$file = fopen("js/Levels/First/setSpeed.js", 'wb');//creates new file
		
		$_SESSION["update"] = "true";
		fwrite($file, $data);
		fclose($file);
	}
?>