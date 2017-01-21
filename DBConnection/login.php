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
					<?php 
					if(!empty($_SESSION['messagenotloggedin']))
					{
						echo $_SESSION['messagenotloggedin']; 
					} 
					?>
				</div>
				<?php 
				unset($_SESSION['messagenotloggedin']); 
				?>
			</div>
		</form>
	</div>
</div>
</body>
</html>
<script>
	document.getElementById("loginform").onsubmit = function () {
    var x = document.forms["loginform"]["login"].value;
    var y = document.forms["loginform"]["password"].value;
    var submit = true;

    if (x == null || x == "") {
        nameError = "Please enter your name";
        document.getElementById("login_error").innerHTML = nameError;
        submit = false;
    }

    if (y == null || y == "") {
        passError = "Please enter your password";
        document.getElementById("password_error").innerHTML = passError;
        submit = false;
    }

    

    return submit;
}

function removeWarning() {
    document.getElementById(this.id + "_error").innerHTML = "";
}

 document.getElementById("login").onkeyup = removeWarning;
 document.getElementById("password").onkeyup = removeWarning;
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
			header('location: logged.php');
		}
		else{
			//header("Location: login.php");
			echo '<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>You are not logged in!</div>';;
			 
		}
	}



}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>  

