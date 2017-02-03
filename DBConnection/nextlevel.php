<?php

//include "dbconfig.php";
session_start();
$servername = "localhost";
$user = "root";
$pass = "root";
$errflag = false;

try {
	//set the connection to DB
	$conn = new PDO("mysql:host=$servername;dbname=desertdb", $user, $pass);
    // set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if(!$conn){
		echo "Error! You are not connected!";
	}

	// Retrieve of the data inputby user
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		$current_player = $_SESSION['loggedinUser'];
		$old_total_score = $_SESSION['totalScore'];
		$old_current_level_score = $_SESSION['maxCurrentLevelScore'];
		$max_level = $_SESSION['maxLevel'];
		$new_current_level_score = 777;
		//$new_current_level_score = $_SESSION['levelScore'];
	} else {
		echo '<script type="text/javascript">alert("non sei loggato");</script>';
	}

	// Se è più grande, aggiorna lo score record del livello
	if($new_current_level_score > $old_current_level_score) {
		$update_score_query = conn->prepare("UPDATE Campaign SET score= :s WHERE login= :log AND level= :l");
	  $update_score_query->bindParam(':s', $new_current_level_score);
	  $update_score_query->bindParam(':log', $current_player);
	  $update_score_query->bindParam(':l', $max_level);
	  $update_score_query->execute();
	}

	// E una volta finito il livello aggiorna anche lo score totale
	$new_total_score = $old_total_score + $new_current_level_score;
	$_SESSION['totalScore'] = $new_total_score;
	$update_total_score = conn->prepare("UPDATE User SET score= :s WHERE login= :log");
	$update_total_score->bindParam(':s', $new_total_score);
	$update_total_score->bindParam(':log', $current_player);
	$update_total_score->execute();

  // Aggiornamento grado

	// Aggiornamento achievements

	// Inserzione nuovo livello sbloccato
	if ($max_level < 10) {
		$max_level = $max_level + 1;
		$sql_campaign_insertion = "INSERT INTO Campaign ( login, level, score ) VALUES ( :log, :l, :s)";
		$sql_campaign_insertion->bindParam(':log', $current_player);
		$sql_campaign_insertion->bindParam(':l', $max_level);
		$sql_campaign_insertion->bindParam(':s', 0);
	}
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
