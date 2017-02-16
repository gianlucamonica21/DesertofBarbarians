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
	// Retrieve of the data inputby user
	$login = $_POST['username'];
	$password = $_POST['password'];

	// Check the input of data
	if(!empty($login) and !empty($password)){
    // Query to login
		$user_query = $conn->prepare("SELECT * FROM User WHERE BINARY login= :login AND BINARY password= :password");
		$user_query->bindParam(':login', $login);
		$user_query->bindParam(':password', $password);
		$user_query->execute();
		$user_rows = $user_query->fetch();

		if($user_rows > 0) {
			$total_score = $user_rows["score"];
			$_SESSION['totalScore'] = $total_score;

			// Save the user loggedin
			$_SESSION['loggedin'] = true;
			$_SESSION['loggedinUser'] = $login;
			//$_SESSION["staticallyLevel"] = false;

		    //echo '<script>alert("sono dentro");</script>';
			$level_query = $conn->prepare("SELECT MAX(level) AS maxlevel FROM Campaign WHERE login= :login");
			$level_query->bindParam(':login', $login);
			$level_query->execute();
			$level_rows = $level_query->fetch();
			$levelstart = $level_rows["maxlevel"];
			$_SESSION['level'] = $levelstart;
			$_SESSION['maxLevel'] = $levelstart;

			// Estrai grado
			$grade_query = $conn->prepare("SELECT * FROM Graduated WHERE login= :login");
			$grade_query->bindParam(':login', $login);
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
			$achievements_query->bindParam(':login', $login);
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

			//Caricamento dati leaderboard
			$leader_query = $conn->prepare("SELECT login, score FROM User ORDER BY score DESC LIMIT 5");
			$leader_query->execute();
			$leaders = $leader_query->fetchAll();

			foreach ($leaders as $leader)
			{
				$leader_names[] = $leader["login"];
				$leader_scores[] = $leader["score"];
			}

			// Save the leaders info
			$user_query = $conn->prepare("SELECT * FROM User WHERE login= :login");
			$user_query->bindParam(':login', $login);
			$user_query->execute();
			$user_rows2 = $user_query->fetch();
			$total_score = $user_rows2["score"];
			$_SESSION['totalScore'] = $total_score;

			// Estrai grado
			$grade_query = $conn->prepare("SELECT * FROM Graduated WHERE login= :login");
			$grade_query->bindParam(':login', $login);
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


			$_SESSION['leaderNames'] = $leader_names;
			$_SESSION['leaderScores'] = $leader_scores;
			$_SESSION['NUMBER']	= count($leader_names);

			foreach ($leader_names as $name) {
				// Estrai tutti i badge mai guadagnati dai giocatori nella leaderboard
				$achievements_query = $conn->prepare("SELECT COUNT(*) AS Badges FROM Achieved WHERE login= :login");
				$achievements_query->bindParam(':login', $name);
				$achievements_query->execute();
				$achievements_row = $achievements_query->fetch();

				$badges[] = $achievements_row["Badges"];
			}
			$_SESSION['leaderBadges'] = $badges;
			$_SESSION['isChampion'] = false;

			echo "OK";
			//header('Location: ../index.php');
		}
		else {

			http_response_code(404);
			echo 'Wrong password or username. Please try again or register.';
		}
	}
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
