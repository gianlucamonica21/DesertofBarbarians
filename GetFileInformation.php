<?php
	//get information of file, NOW NOT USED
	$file="js/Levels/First/first.js";
	$linecount = 0;
	$handle = fopen($file, "r");
	while(!feof($handle)){
	  $line = fgets($handle);
	  $linecount++;
	}

	fclose($handle);

	echo $linecount;
?>