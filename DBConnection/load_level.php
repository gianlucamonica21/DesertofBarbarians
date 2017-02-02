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

		if($grade_rows > 0 and
			 	$level_rows > 0 and
			 	$constrows_rows > 0 and
			 	$achievements_rows > 0) {

			header('Location: ../index.php');
		}
		else {
			echo '<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>You are not registered, or you enter a wrong user or a wrong password. Please verify!<A HREF="registration.php">Please go here.</A></div>';
		}
	}
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
