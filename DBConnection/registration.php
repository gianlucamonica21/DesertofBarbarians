
  <!DOCTYPE html>
  <html>
  <head>
    <title>Registration Page</title>
  </head>
  <!-- BOOTSTRAP-->
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/custom.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <body  >
    <div class="row" >
      <div class="col-md-5 well" >
        <div class="form-group" >

          <h1>Registration</h1>
          <form name="registration" id="registration" method="POST">

            <label for="">Login</label>
            <input id="username" type="text" name="username" class="form-control"/>
            <span class="error"><p id="username_error"></p></span>

            <label for="">Password</label>
            <input id="password" type="password" name="password" class="form-control"/>
            <span class="error"><p id="password_error"></p></span>
          </div>
          <div class="form-group">
            <input type="submit" name="btnLogin" class="btn btn-primary" value="Register"/>
          </div>
        </form>
      </div>
    </div>
    <script src="js/registration.script.js">
    </script>​
    <?php
 
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
    if(!$conn){
      echo "Error! You are not connected!";
    }
    //setting var from the form
    
    $errflag = false;
    $username = $_POST[ 'username' ];
    $password = $_POST[ 'password' ];
    $score = 0;

    //check the input of data

    //sql code to do the insert
    $sql = "INSERT INTO User ( login, password, score ) VALUES ( :login, :password, :score)";

    //exec the query on db to register
    $query = $conn->prepare( $sql );
    if(!empty($username) and !empty($password)){

      $result = $query->execute( array( ':login'=>$username, ':password'=>$password, ':score'=>$score) );

      if ( $result ){
          //header('location: registered.php');
       header('Location: ../index.html');
       
     } 
     
   }
   
 }
 catch(PDOException $e)
 {
  echo '<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Database error!Please check the input!</div>';
  //. $e->getMessage();
}

$conn = null;


?>
</body>
</html>