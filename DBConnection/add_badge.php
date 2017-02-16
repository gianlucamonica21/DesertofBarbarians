<?php
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

	// Retrieve of the data inputby user
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		$current_player = $_SESSION['loggedinUser'];
		$badge = $_POST['data'];
	} else {
		echo '<script type="text/javascript">alert("non sei loggato");</script>';
	}

  $check_badge = $conn->prepare("SELECT * FROM Achieved WHERE login= :login AND achievement= :badge");
	$check_badge->bindParam(':login', $current_player);
  $check_badge->bindParam(':badge', $badge);
	$check_badge->execute();
	$checked_badge = $check_badge->fetch();

  if ($checked_badge == 0) {
    $add_badge = "INSERT INTO Achieved ( login, achievement ) VALUES ( :login, :achievement )";
		$query = $conn->prepare($add_badge);
		$result = $query->execute( array( ':login'=>$current_player,
	 																		':achievement'=>$badge) );
  }
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
