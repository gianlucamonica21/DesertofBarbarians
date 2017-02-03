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
		$new_current_level_score = 2123;
		//$new_current_level_score = $_SESSION['levelScore'];
	} else {
		echo '<script type="text/javascript">alert("non sei loggato");</script>';
	}

	echo "Prima di aggiornare i parametri sono i seguenti. Player: ".$_SESSION['loggedinUser']." Totale punti: ".$_SESSION['totalScore']." Grado: ".$_SESSION['userGrade']." Livello Massimo: ".$_SESSION['maxLevel']." Record Livello: ".$_SESSION['maxCurrentLevelScore'];

	// Se è più grande, aggiorna lo score record del livello
	if($new_current_level_score > $old_current_level_score) {
		$update_campaign = "UPDATE Campaign SET score= :score WHERE login= :login AND level= :level";
		$query = $conn->prepare($update_campaign);
		$result_update_campaign = $query->execute( array( ':score'=>$new_current_level_score,
																							 ':login'=>$current_player,
																							 ':level'=>$max_level) );
  }

	// E una volta finito il livello aggiorna anche lo score totale
	$new_total_score = $old_total_score + $new_current_level_score;
	$_SESSION['totalScore'] = $new_total_score;
	$update_total_score = "UPDATE User SET score= :score WHERE login= :login";
	$query = $conn->prepare($update_total_score);
	$result_update_total_score = $query->execute( array( ':score'=>$new_total_score,
 																								':login'=>$current_player) );

  // Aggiornamento grado

	// Aggiornamento achievements

	// Inserzione nuovo livello sbloccato
	if ($max_level < 10) {
		$max_level = $max_level + 1;
    $max_score_per_level = 0;
    $sql_campaign_insertion = "INSERT INTO Campaign ( login, level, score ) VALUES ( :login, :level, :max_score_per_level)";
		$query = $conn->prepare($sql_campaign_insertion);
		$result_campaign = $query->execute( array( ':login'=>$current_player,
																							 ':level'=>$max_level,
																							 ':max_score_per_level'=>$max_score_per_level) );
	}
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
