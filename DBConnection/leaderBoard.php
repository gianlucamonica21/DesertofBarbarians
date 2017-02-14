<?php

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

	$leader_query = $conn->prepare("SELECT login, score FROM User ORDER BY score DESC LIMIT 5");
	$leader_query->execute();
	$leaders = $leader_query->fetchAll();
	foreach ($leaders as $leader)
	{
		$leader_names[] = $leader["login"];
		$leader_scores[] = $leader["score"];
	}

	session_start();
	// Save the leaders info
	$_SESSION['leaderNames'] = $leader_names;
	$_SESSION['leaderScores'] = $leader_scores;

	foreach ($leader_names as $name) {
		// Estrai tutti i badge mai guadagnati dai giocatori nella leaderboard
		$achievements_query = $conn->prepare("SELECT COUNT(*) AS Badges FROM Achieved WHERE login= :login");
		$achievements_query->bindParam(':login', $name);
		$achievements_query->execute();
		$achievements_row = $achievements_query->fetch();

		$badges[] = $achievements_row["Badges"];
	}
	$_SESSION['leaderBadges'] = $badges;

	if($leaders > 0) {
		echo ($leader_names);
		//print_r($leader_scores);
		//header('Location: ../index.php');
	}
	else {
		http_response_code(404);
		echo 'Wrong password or username. Please try again or register.';
	}
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
