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

		$grade_type = $conn->prepare("SELECT * FROM Grade WHERE id= :id");
		$grade_type->bindParam(':id', $grade);
		$grade_type->execute();
		$grade_type_row = $grade_type->fetch();
		$type = $grade_type_row["type"];
		$_SESSION['gradeType'] = $type;

		// Estrai prossimo grado e requisito
		$next_grade = $grade + 1;
		$desiderable_grade = $conn->prepare("SELECT * FROM Grade WHERE id= :id");
		$desiderable_grade->bindParam(':id', $next_grade);
		$desiderable_grade->execute();
		$desiderable_grade_row = $desiderable_grade->fetch();
		if ($desiderable_grade_row == 0) {
			// Estrai prossimo grado e requisito, maxim, grade 1, nextgrade 1
			$next_grade = $grade;
		}
		else {
			// Estrai prossimo grado e requisito, maxim, grade 1, nextgrade 2
			$next_grade_score = $desiderable_grade_row["score"];
			$next_grade_details = $desiderable_grade_row["type"];
			$_SESSION['nextGradeScore'] = $next_grade_score;
			$_SESSION['nextGradeDetails'] = $next_grade_details;
		}
		$_SESSION['nextGrade'] = $next_grade;

		// Estrai tutti gli achievement (o badge) mai guadagnati dal giocatore
		$achievements_query = $conn->prepare("SELECT * FROM Achieved WHERE login= :login");
		$achievements_query->bindParam(':login', $current_player);
		$achievements_query->execute();
		$achievements_rows = $achievements_query->fetchAll();
		foreach ($achievements_rows as $achievements_row) {
			/* L'array achievements conterrà i codici di tutti i badges mai
			   guadagnati dall'utente appena loggato */
			$achievements[] = $achievements_row["achievement"];

			$badge_info_query = $conn->prepare("SELECT * FROM Achievement WHERE id= :id");
			$badge_info_query->bindParam(':id', $achievements_row["achievement"]);
			$badge_info_query->execute();
			$badge_info = $badge_info_query->fetch();

			$achievements_title[] = $badge_info["title"];
			$achievements_descr[] = $badge_info["descr"];
		}
		$_SESSION['achievementsQty'] = count($achievements_rows);
		$_SESSION['achievementsId'] = $achievements;
		$_SESSION['achievementsTitle'] = $achievements_title;
		$_SESSION['achievementsDescr'] = $achievements_descr;

		echo "Caricato il livello con i seguenti parametri. Player: ".$_SESSION['loggedinUser']." Totale punti: ".$_SESSION['totalScore']." Grado: ".$_SESSION['userGrade'].$_SESSION['gradeType'];
	}
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
