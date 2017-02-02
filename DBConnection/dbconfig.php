 <?php

 $servername = "localhost";
 $user = "root";
 $pass = "root";

 try {
 	$conn = new PDO("mysql:host=$servername;dbname=desertdb", $user, $pass);
    // set the PDO error mode to exception
 	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 	echo "Connected successfully";


 	}
 	catch(PDOException $e)
 	{
 		echo "Connection failed: " . $e->getMessage();
 	}

 	$conn = null;
 	?>  
<!DOCTYPE html>
<html>
<head>
	<br>
	<title>Connection Page</title>
</head>
<body>
Connection Page
</body>
</html>