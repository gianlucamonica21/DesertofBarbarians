<?php
//require "dbconfig.php";

if ( empty( $_POST ) ) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Registration Page</title>
    </head>
    <body>
        <h1>Registration</h1>
        <form name="registration" action="registration.php" method="POST">
          <label for 'username'>Username: </label>
          <input type="text" name="username"/>

          <label for 'password'>Password: </label>
          <input type="password" name="password"/>

          <br>
          <button type="submit">Submit</button>
      </form>
      <?php
  } else {
 // print_r( $_POST );
  }
  //include "dbconfig.php";

  // setting var to connect to the DB
  $servername = "localhost";
  $user = "root";
  $pass = "root";

  try {
    //connection to the DB
    $conn = new PDO("mysql:host=$servername;dbname=desertdb", $user, $pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";

    //setting var from the form
    $form = $_POST;
    $username = $form[ 'username' ];
    $password = $form[ 'password' ];
    $score = 0;

    //check the input of data
    if($username == '') {
        echo '<br><br>You must enter your Username <br>';
        $errflag = true;
    }
    else{
        echo $login;
    }
    if($password == '') {
        echo 'You must enter your Password';
        $errflag = true;
    }

    if($errflag){
        return 0;
    }

    //sql code to do the insert
    $sql = "INSERT INTO User ( login, password, score ) VALUES ( :login, :password, :score)";

    //exec the query on db to register
    $query = $conn->prepare( $sql );
    $result = $query->execute( array( ':login'=>$username, ':password'=>$password, ':score'=>$score) );

    if ( $result ){
      echo "<p><br><br>Thank you. You have been registered</p>";
  } else {
      echo "<p><br><br>Sorry, there has been a problem inserting your details. Please contact admin.</p>";
  }

}
catch(PDOException $e)
{
    echo "<br>Connection failed: " . $e->getMessage();
}

$conn = null;


?>
</body>
</html>