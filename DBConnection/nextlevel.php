<?php
//include "dbconfig.php";
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
	//retrieve of the data inputby user
	$current_player = "maxim";
	$password = "maxim";

	//check the input of data
	if(!empty($login) and !empty($password)){
    /*
    	Codice temporaneo da spostare, quando un utente finisce un livello
    */
    // Altrimenti, e se è più grande, aggiorna lo score
    $update_score_query = conn->prepare("UPDATE Campaign SET score= :score WHERE login= :login AND level= :level");
    $update_score_query->bindParam(':score', $new_level_score);
    $update_score_query->bindParam(':login', $current_player);
    $update_score_query->bindParam(':level', $current_level);
    $update_score_query->execute();

    // E una volta finito il livello aggiorna anche lo score totale
    // Lo score totale lo si prende con la query riciclabile da login.php
    // In php lo si somma ai punti appena guadagnati e si fa SET
    $new_total_score = 0;
    $update_total_score = conn->prepare("UPDATE User SET score= :score WHERE login= :login");
    $update_total_score->bindParam(':score', $new_total_score);
    $update_total_score->bindParam(':login', $current_player);
    $update_total_score->execute();

    // Ma bisogna aggiornare anche grado

    // Entrati in un nuovo livello, esrai le relative informazioni
    // query riusabile da login.php
		if(true) {
			//header('location: logged.php');
			header('Location: ../index.html');
		}
		else{
			//header("Location: login.php");
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
