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

		if(!empty($current_player)){
			

		// Estrai massimo livello completato dal giocatore
		$level_query = $conn->prepare("SELECT MAX(level) AS maxlevel FROM Campaign WHERE login= :login");
		$level_query->bindParam(':login', $current_player);
		$level_query->execute();
		$level_rows = $level_query->fetch();
		$max_level = $level_rows["maxlevel"];
		//$_SESSION['maxLevel'] = $max_level;
		echo $maxlevel;
		}
		
	}
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
