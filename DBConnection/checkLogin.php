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
		$user_query = $conn->prepare("SELECT * FROM User WHERE login= :login AND password= :password");
		$user_query->bindParam(':login', $login);
		$user_query->bindParam(':password', $password);
		$user_query->execute();
		$user_rows = $user_query->fetch();

		
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

		//Caricamento dati leaderboard
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
		$_SESSION['NUMBER']	= count($leader_names);	
						


		if($user_rows > 0) {
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