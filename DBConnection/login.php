<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
</head>
<!-- BOOTSTRAP-->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/font-awesome.min.css">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<body>

	<div class="row">
		<div class="col-md-5 well">
			<h1>Login</h1>

			<form action="login.php" method="post" id="loginform">
				<div class="form-group">
					<label for="">Login</label>
					<input id="login" type="text" name="login" class="form-control"/> <span class="error"><p id="login_error"></p></span>

					<label for="">Password</label>
					<input id="password" type="password" name="password" class="form-control"/> <span class="error"><p id="password_error"></p></span>
				</div>
				<div class="form-group">
					<input type="submit" name="btnLogin" class="btn btn-primary" value="Login"/>

				</div>

			</div>
		</form>
	</div>
</div>
</body>
</html>
<script src="js/login.script.js">
</script>​
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
	$login = $_POST['login'];
	$password = $_POST['password'];

	// Check the input of data
	if(!empty($login) and !empty($password)){
    // Query to login
		$user_query = $conn->prepare("SELECT * FROM User WHERE login= :login AND password= :password");
		$user_query->bindParam(':login', $login);
		$user_query->bindParam(':password', $password);
		$user_query->execute();
		$user_rows = $user_query->fetch();
<<<<<<< HEAD
		//save the user loggedin
		

		/* 	Riga originale ma non funzionante
				$rows = $result->fetch(PDO::FETCH_NUM); */
		
		$total_score = $user_rows["score"];
		$_SESSION['totalScore'] = $total_score;

		// l.2 Estrai grado
		$grade_query = $conn->prepare("SELECT * FROM Graduated WHERE login= :login");
		$grade_query->bindParam(':login', $login);
		$grade_query->execute();
		$grade_rows = $grade_query->fetch();
		$grade = $grade_rows["grade"];
		$_SESSION['userGrade'] = $grade;

		// l.3 Estrai massimo livello completato dal giocatore
		$level_query = $conn->prepare("SELECT MAX(level) AS maxlevel FROM Campaign WHERE login= :login");
		$level_query->bindParam(':login', $login);
		$level_query->execute();
		$level_rows = $level_query->fetch();
		$max_level = $level_rows["maxlevel"];
		$_SESSION['maxLevel'] = $max_level;

		/* l.4 Estrai lo score dentro tale livello, se l'utente non lo ha mai completato
			allora lo score sarà zero */
		$score_query = $conn->prepare("SELECT score FROM Campaign WHERE login= :login AND level= :level");
		$score_query->bindParam(':login', $login);
		$score_query->bindParam(':level', $max_level);
		$score_query->execute();
		$score_row = $score_query->fetch();
		$max_level_record_score = $score_row["score"];
		$_SESSION['maxCurrentLevelScore'] = $max_level_record_score;

		// l.5 Estrai le righe non modificabili per il massimo livello
		$constrows_query = $conn->prepare("SELECT * FROM ConstRow WHERE level= :level");
		$constrows_query->bindParam(':level', $max_level);
		$constrows_query->execute();
		$constrows_rows = $constrows_query->fetchAll();
		foreach ($constrows_rows as $constrow) {
			/* L'array constrows conterrà i numeri di tutte le righe costanti
			   per il livello caricato dopo il login */
			$constrows[] = $constrow["row"];
		}

		// l.6 Estrai tutti gli achievement (o badge) mai guadagnati dal giocatore
		$achievements_query = $conn->prepare("SELECT * FROM Achieved WHERE login= :login");
		$achievements_query->bindParam(':login', $login);
		$achievements_query->execute();
		$achievements_rows = $achievements_query->fetchAll();
		foreach ($achievements_rows as $achievements_row) {
			/* L'array achievements conterrà i codici di tutti i badges mai
			   guadagnati dall'utente appena loggato */
			$achievements[] = $achievements_row["achievement"];
		}

		if($user_rows > 0
			 and
			 	$grade_rows > 0 and
			 	$level_rows > 0 and
			 	$constrows_rows > 0 and
			 	$achievements_rows > 0)
			 {
			//header('location: logged.php');
		 	$_SESSION['loggedin'] = true;
			$_SESSION['loggedinUser'] = $login;
=======

		// Save the user loggedin
		$_SESSION['loggedin'] = true;
		$_SESSION['loggedinUser'] = $login;

		if($user_rows > 0) {
>>>>>>> a4f07ec4f27c2b87486d68595213e3ad8075f0af
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
