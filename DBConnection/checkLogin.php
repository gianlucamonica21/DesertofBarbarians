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

		session_start();
		// Save the user loggedin
		$_SESSION['loggedin'] = true;
		$_SESSION['loggedinUser'] = $login;

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