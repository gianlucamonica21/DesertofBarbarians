<?php
	session_start();
	// Saves user solution to file
	if(!empty($_POST['data'])){
		$data = $_POST['data'];
		echo '<script>alert("CI SONO");</script>';
		$_SESSION["level"] = $data;	
		$_SESSION["staticallyLevel"] = true;	
	}
?>