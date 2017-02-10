<?php
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

		// Informazione sull'utente
		$current_level = $_SESSION['level'];
		$max_level = $_SESSION['maxLevel'];
		$old_total_score = $_SESSION['totalScore'];
		$old_current_level_score = $_SESSION['maxCurrentLevelScore'];

		// Variabili per calcolo del punteggio
		$time_to_finish = $_POST['data'];
		$points_coef = $_SESSION['pointsCoef'];
		$time_limit = $_SESSION['timeLimit'];

		// Variabili per Aggiornamento del Grado
		$grade = $_SESSION['userGrade'];
		$next_grade = $_SESSION['nextGrade'];
		$next_grade_score = $_SESSION['nextGradeScore'];
		$next_grade_details = $_SESSION['nextGradeDetails'];
	} else {
		echo '<script type="text/javascript">alert("non sei loggato");</script>';
	}
	echo "Prima di aggiornare i parametri sono i seguenti. TIME: ".$time_to_finish." Player: ".$_SESSION['loggedinUser']." Totale punti: ".$_SESSION['totalScore']." Grado: ".$_SESSION['userGrade']." Livello Massimo: ".$_SESSION['maxLevel']." Record Livello: ".$_SESSION['maxCurrentLevelScore'];

	/* Se è più grande aggiorna lo score record del livello,
		che viene calcolato prendendo il tempo ancora rimasto a disposizione dell'utente
		e trasformandolo in percentuale, per poi essere moltiplicato per un Coefficiente
		di difficoltà perstabilito per ogni livello. */
	if ($time_to_finish > $time_limit) {
		$new_current_level_score = 0;
	}
	else {
		$new_current_level_score = ((($time_limit - $time_to_finish) / $time_limit) * 100) * $points_coef;
	}
	if($new_current_level_score > $old_current_level_score) {
		$update_campaign = "UPDATE Campaign SET score= :score WHERE login= :login AND level= :level";
		$query = $conn->prepare($update_campaign);
		$result_update_campaign = $query->execute( array( ':score'=>$new_current_level_score,
																							 ':login'=>$current_player,
																							 ':level'=>$current_level) );
  }

	// E una volta finito il livello aggiorna anche lo score totale
	$new_total_score = $old_total_score + $new_current_level_score;
	$_SESSION['totalScore'] = $new_total_score;
	$update_total_score = "UPDATE User SET score= :score WHERE login= :login";
	$query = $conn->prepare($update_total_score);
	$result_update_total_score = $query->execute( array( ':score'=>$new_total_score,
 																								':login'=>$current_player) );

  // Aggiornamento grado, solo se con requisiti necessari
	if ($new_total_score >= $next_grade_score &&
			$grade < $next_grade) {
		$update_grade = "UPDATE Graduated SET grade= :next_grade WHERE login= :login";
		$query = $conn->prepare($update_grade);
		$result = $query->execute( array(':next_grade'=>$next_grade,
																			':login'=>$current_player) );
	}

	// Aggiornamento achievements
	/*
	if (true) {
		$add_badge = "INSERT INTO Achieved ( login, achievement ) VALUES ( :login, :achievement )";
		$query = $conn->prepare($add_badge);
		$result = $query->execute( array( ':login'=>$current_player,
	 																		':achievement'=>$badge) );
	}
	*/

	// Inserzione nuovo livello sbloccato
	if ($current_level < 9 &&
			$current_level == $max_level) {
		$current_level = $current_level + 1;
    $max_score_per_level = 0;
    $sql_campaign_insertion = "INSERT INTO Campaign ( login, level, score ) VALUES ( :login, :level, :max_score_per_level)";
		$query = $conn->prepare($sql_campaign_insertion);
		$result_campaign = $query->execute( array( ':login'=>$current_player,
																							 ':level'=>$current_level,
																							 ':max_score_per_level'=>$max_score_per_level) );
	}
	if ($current_level < 9 &&
		 $current_level < $max_level) {
		$current_level = $current_level + 1;
	}

	$_SESSION['level'] = $current_level;
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
