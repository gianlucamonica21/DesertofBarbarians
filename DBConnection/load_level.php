<?php
session_start();
$servername = "localhost";
$user = "root";
$pass = "root";
$errflag = false;

try {
// Set the connection to DB
	$conn = new PDO("mysql:host=$servername;dbname=desertdb", $user, $pass);
    // Set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if(!$conn){
		echo "Error! You are not connected!";
	}
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $current_player = $_SESSION['loggedinUser'];
	$level_to_load = $_POST['levelToLoad'];
  } else {
	  echo '<script type="text/javascript">alert("non sei loggato");</script>';
	}

	// Check the input of data
	if(!empty($current_player)){
		$user_query = $conn->prepare("SELECT * FROM User WHERE login= :login");
		$user_query->bindParam(':login', $current_player);
		$user_query->execute();
		$user_rows = $user_query->fetch();
		$total_score = $user_rows["score"];
		$_SESSION['totalScore'] = $total_score;

		// Estrai grado
		$grade_query = $conn->prepare("SELECT * FROM Graduated WHERE login= :login");
		$grade_query->bindParam(':login', $current_player);
		$grade_query->execute();
		$grade_rows = $grade_query->fetch();
		$grade = $grade_rows["grade"];
		$_SESSION['userGrade'] = $grade;

		// Estrai prossimo grado e requisito
		$next_grade = $grade + 1;
		$desiderable_grade = $conn->prepare("SELECT * FROM Grade WHERE id= :id");
		$desiderable_grade->bindParam(':id', $next_grade);
		$desiderable_grade->execute();
		$desiderable_grade_row = $desiderable_grade->fetch();
		if ($desiderable_grade_row == 0)
			$next_grade = $grade;
		$next_grade_score = $desiderable_grade_row["score"];
		$next_grade_details = $desiderable_grade_row["type"];
		$_SESSION['nextGrade'] = $next_grade;
		$_SESSION['nextGradeScore'] = $next_grade_score;
		$_SESSION['nextGradeDetails'] = $next_grade_details;

		// Estrai massimo livello completato dal giocatore
		$level_query = $conn->prepare("SELECT MAX(level) AS maxlevel FROM Campaign WHERE login= :login");
		$level_query->bindParam(':login', $current_player);
		$level_query->execute();
		$level_rows = $level_query->fetch();
		$max_level = $level_rows["maxlevel"];
		$_SESSION['maxLevel'] = $max_level;

		/* Estrai lo score dentro tale livello, se l'utente non lo ha mai completato
			allora lo score sarà zero */
		$score_query = $conn->prepare("SELECT score FROM Campaign WHERE login= :login AND level= :level");
		$score_query->bindParam(':login', $current_player);
		$score_query->bindParam(':level', $max_level);
		$score_query->execute();
		$score_row = $score_query->fetch();
		$max_level_record_score = $score_row["score"];
		$_SESSION['maxCurrentLevelScore'] = $max_level_record_score;

		// Estrai Coefficiente di difficoltà e limite di tempo
		$level_query = $conn->prepare("SELECT rows, coef, timelimit FROM Level WHERE level= :level");
		$level_query->bindParam(':level', $max_level);
		$level_query->execute();
		$level_details = $level_query->fetch();
		$tot_rows = $level_details["rows"];
		$points_coef = $level_details["coef"];
		$time_limit = $level_details["timelimit"];
		$_SESSION['totalRows'] = $tot_rows;
		$_SESSION['pointsCoef'] = $points_coef;
		$_SESSION['timeLimit'] = $time_limit;

		// Estrai le righe non modificabili per il massimo livello
		$constrows_query = $conn->prepare("SELECT * FROM ConstRow WHERE level= :level");
		$constrows_query->bindParam(':level', $max_level);
		$constrows_query->execute();
		$constrows_rows = $constrows_query->fetchAll();
		foreach ($constrows_rows as $constrow) {
			/* L'array constrows conterrà i numeri di tutte le righe costanti
			   per il livello caricato dopo il login */
			$constrows[] = $constrow["row"];
		}

		// Estrai tutti gli achievement (o badge) mai guadagnati dal giocatore
		$achievements_query = $conn->prepare("SELECT * FROM Achieved WHERE login= :login");
		$achievements_query->bindParam(':login', $current_player);
		$achievements_query->execute();
		$achievements_rows = $achievements_query->fetchAll();
		foreach ($achievements_rows as $achievements_row) {
			/* L'array achievements conterrà i codici di tutti i badges mai
			   guadagnati dall'utente appena loggato */
			$achievements[] = $achievements_row["achievement"];
		}
		echo "Caricato il livello con i seguenti parametri. Player: ".$_SESSION['loggedinUser']." Totale punti: ".$_SESSION['totalScore']." Grado: ".$_SESSION['userGrade']." Livello Massimo: ".$_SESSION['maxLevel']." Record Livello: ".$_SESSION['maxCurrentLevelScore'];
	}
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
