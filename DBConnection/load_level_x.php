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
		$level_to_load = $_POST['data'];
  } else {
	  echo '<script type="text/javascript">alert("non sei loggato");</script>';
	}

	// Check the input of data
	if(!empty($current_player)){
		// Estrai massimo livello completato dal giocatore
		$level_query = $conn->prepare("SELECT MAX(level) AS maxlevel FROM Campaign WHERE login= :login");
		$level_query->bindParam(':login', $current_player);
		$level_query->execute();
		$level_rows = $level_query->fetch();
		$max_level = $level_rows["maxlevel"];
		$_SESSION['maxLevel'] = $max_level;

		$loaded_level = 0;
		// Se è dopo il login e non c'è nessun livello caricato, carica il massimo
		if (!isset($_SESSION['level'])) {
			$loaded_level = $_SESSION['maxLevel'];
			$_SESSION['level'] = $loaded_level;
		}
		// Se qualche livello è stato già caricato
		else {
			// Ma non è stato premuto alcun bottone, allora ricarica il livello
			if ($level_to_load < 1 || $level_to_load > 9) {
				$loaded_level = $_SESSION['level'];
			}
			// Ma è stato premuto un bottone x, allroa carica l'x-esimo livello
			else {
				$loaded_level = $level_to_load;
				$_SESSION['level'] = $loaded_level;
			}
		}

		// Se il livello da caricare è 0 significa che va caricato il massimo
		// if ($level_to_load == 0) {
		// 	$loaded_level = $max_level;
		// }
		// $_SESSION['level'] = $loaded_level;

		/* Estrai lo score dentro tale livello, se l'utente non lo ha mai completato
			allora lo score sarà zero */
		$score_query = $conn->prepare("SELECT score FROM Campaign WHERE login= :login AND level= :level");
		$score_query->bindParam(':login', $current_player);
		$score_query->bindParam(':level', $loaded_level);
		$score_query->execute();
		$score_row = $score_query->fetch();
		$max_level_record_score = $score_row["score"];
		$_SESSION['maxCurrentLevelScore'] = $max_level_record_score;

		// Estrai Coefficiente di difficoltà e limite di tempo
		$level_query = $conn->prepare("SELECT rows, coef, timelimit FROM Level WHERE level= :level");
		$level_query->bindParam(':level', $loaded_level);
		$level_query->execute();
		$level_details = $level_query->fetch();
		$tot_rows = $level_details["rows"];
		$points_coef = $level_details["coef"];
		$time_limit = $level_details["timelimit"];
		$_SESSION['totalRows'] = $tot_rows;
		$_SESSION['pointsCoef'] = $points_coef;
		$_SESSION['timeLimit'] = $time_limit;

		// Estrai le righe non modificabili per il livello attuale
		$constrows_query = $conn->prepare("SELECT * FROM ConstRow WHERE level= :level");
		$constrows_query->bindParam(':level', $loaded_level);
		$constrows_query->execute();
		$constrows_rows = $constrows_query->fetchAll();
		foreach ($constrows_rows as $constrow) {
			/* L'array constrows conterrà i numeri di tutte le righe costanti
			   per il livello caricato dopo il login */
			$constrows[] = $constrow["row"];
		}
		$_SESSION['constRows'] = $constrows;

		echo "Caricato il livello con i seguenti parametri. Player: ".$_SESSION['loggedinUser']." Totale punti: ".$_SESSION['totalScore']." Grado: ".$_SESSION['userGrade']." Livello Massimo: ".$_SESSION['maxLevel']." Record Livello: ".$_SESSION['maxCurrentLevelScore']."readonlylines: ".$_SESSION['constRows'];
	}
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
