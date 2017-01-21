<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
</head>
<body>
	<div class="row">
		<div class="col-md-5 well">
			<h4>Login</h4>
			<?php
			if ($login_error_message != "") {
				echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $login_error_message . '</div>';
			}
			?>
			<form action="login.php" method="post">
				<div class="form-group">
					<label for="">Login</label>
					<input type="text" name="login" class="form-control"/>

					<label for="">Password</label>
					<input type="password" name="password" class="form-control"/>
				</div>
				<div class="form-group">
					<input type="submit" name="btnLogin" class="btn btn-primary" value="Login"/>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
<?php
//include "dbconfig.php";
$servername = "localhost";
$user = "root";
$pass = "root";

try {
	//set the connection to DB
	$conn = new PDO("mysql:host=$servername;dbname=desertdb", $user, $pass);
    // set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connected successfully";

	//retrieve of the data inputby user
	$login = $_POST['login'];
	$password = $_POST['password'];

	//check the input of data
	if($login == '') {
        echo '<br><br>You must enter your Username <br>';
        $errflag = true;
    }
    else{
        echo $login;
    }
    if($password == '') {
        echo '<br><br>You must enter your Password';
        $errflag = true;
    }

    if($errflag){
        return 0;
    }

	//query to login
	$result = $conn->prepare("SELECT * FROM User WHERE login= :login AND password= :password");
	$result->bindParam(':login', $login);
	$result->bindParam(':password', $password);
	$result->execute();
	$rows = $result->fetch(PDO::FETCH_NUM);
	if($rows > 0){
		echo "<br><br>you are logged in as --> ".$login;
	}
	else{
		echo "<br><br>you are not logged in!";
	}

}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>  

