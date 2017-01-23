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
	$login = $_POST['login'];
	$password = $_POST['password'];

	//check the input of data
	if(!empty($login) and !empty($password)){
        //query to login
		$result = $conn->prepare("SELECT * FROM User WHERE login= :login AND password= :password");
		$result->bindParam(':login', $login);
		$result->bindParam(':password', $password);
		$result->execute();
		$rows = $result->fetch(PDO::FETCH_NUM);

		if($rows > 0){
			//header('location: logged.php');
			header('Location: ../index.html');
		}
		else{
			//header("Location: login.php");
			echo '<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>You are not registered, or you enter a wrong user or a wrong password! Please verify! If you want to register! <A HREF="registration.php">Please go here.</A></div>';

		}
	}
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>  

