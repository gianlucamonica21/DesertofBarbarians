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

	
	
	$e = "nuovo";
	$ss = 666;
	$level = 1;

	// $update_score_query = 
	// conn->prepare("UPDATE Campaign SET score= :score WHERE login= :login AND level= :level");
	// $result1 = $update_score_query->execute(array(':score'=>666,':login'=>"Nuovo",':level'=>1));
	$sql = "UPDATE Campaign SET score=:s WHERE login='Nuovo' AND level=1";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':s', $ss,PDO::PARAM_INT);
    // execute the query
    $stmt->execute();


	 echo "ho fatto la query!";



	// $update_score_query = conn->prepare("UPDATE Campaign SET score= :score WHERE login= :login AND level= :level");
	// $update_score_query->bindParam(':score', $score);
	// $update_score_query->bindParam(':login', $e);
	// $update_score_query->bindParam(':level', $level);
	// $update_score_query->execute();

	// $user_query = $conn->prepare("SELECT * FROM User WHERE login= :login");
	// 	$user_query->bindParam(':login', $e);
	// 	$user_query->execute();
	// 	$user_rows = $user_query->fetch();
	// 	$total_score = $user_rows["score"];

	//echo 'Questo è lo score di '.$e.': '.$total_score;


	//retrieve of the data inputby user
	// if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	// 	$current_player = $_SESSION['loggedinUser'];
	// 	$old_total_score = $_SESSION['totalScore'];
	// 	$max_level = $_SESSION['maxLevel'];
	// 	$old_current_level_score = $_SESSION['maxCurrentLevelScore'];
	// 	//$new_current_level_score = $_SESSION['levelScore'];
	// } else {
	// 	echo '<script type="text/javascript">alert("non sei loggato");</script>';
	// }

	//check the input of data
	// if( !empty($current_player) ){
    
 //    // Altrimenti, e se è più grande, aggiorna lo score
	// 	if($new_current_level_score > $old_current_level_score) {
	
			
	
	// 	}
	// }

    // E una volta finito il livello aggiorna anche lo score totale
		// $new_total_score = $old_total_score + $new_current_level_score;
		// $_SESSION['totalScore'] = $new_total_score;
		// $update_total_score = conn->prepare("UPDATE User SET score= :score WHERE login= :login");
		// $update_total_score->bindParam(':score', $new_total_score);
		// $update_total_score->bindParam(':login', $current_player);
		// $update_total_score->execute();

 //    // Aggiornamento grado

	// 	// Aggiornamento achievements

	// 	// Inserzione nuovo livello sbloccato
	// 	if ($max_level < 10) {
	// 		$max_level = $max_level + 1;
	// 		$sql_campaign_insertion = "INSERT INTO Campaign ( login, level, score ) VALUES ( :login, :level, :score)";
	// 		$sql_campaign_insertion->bindParam(':login', $current_player);
	// 		$sql_campaign_insertion->bindParam(':level', $max_level);
	// 		$sql_campaign_insertion->bindParam(':score', 0);
	// 	}


	// }
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
