
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
  session_start();
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
    // r.1 Per inserzione tabella User
    $errflag = false;
    $username = $_POST[ 'username' ];
    $password = $_POST[ 'password' ];
    $total_score = 0;
    $sql_user_insertion = "INSERT INTO User ( login, password, score ) VALUES ( :login, :password, :total_score)";

    // r.2 Per inserzione tabella Campaign, inizia da livello zero con score per livello nullo
    $initial_level = 1;
    $max_score_per_level = 0;
    $sql_campaign_insertion = "INSERT INTO Campaign ( login, level, score ) VALUES ( :login, :initial_level, :max_score_per_level)";

    // r.3 Per inserzione tabella Achieved
    $initial_achievement = 1;
    $sql_ach_insertion = "INSERT INTO Achieved ( login, achievement ) VALUES ( :login, :initial_achievement)";

    // r.4 Per inserzione tabella Graduated
    $initial_grade = 1;
    $sql_grade_insertion = "INSERT INTO Graduated ( login, grade ) VALUES ( :login, :initial_grade)";

    //check the input of data

    //exec the query on db to register
    $query = $conn->prepare($sql_user_insertion);
    if(!empty($username) and !empty($password)){
      $result_user = $query->execute( array( ':login'=>$username, ':password'=>$password, ':total_score'=>$total_score) );

      $query = $conn->prepare($sql_campaign_insertion);
      $result_campaign = $query->execute( array( ':login'=>$username,
                                                 ':initial_level'=>$initial_level,
                                                 ':max_score_per_level'=>$max_score_per_level) );
      $query = $conn->prepare($sql_ach_insertion);
      $result_arch = $query->execute( array( ':login'=>$username,
                                            ':initial_achievement'=>$initial_achievement) );
      $query = $conn->prepare($sql_grade_insertion);
      $result_grade = $query->execute( array( ':login'=>$username,
                                             ':initial_grade'=>$initial_grade) );

      // Solo se tutti gli insert sono andati a buon fine
     if ( $result_user and $result_campaign and $result_arch and $result_grade){
          //header('location: registered.php');

          $_SESSION['loggedin'] = true;
          $_SESSION['loggedinUser'] = $username;
          header('Location: ../index.php');
      }
    }
}
catch(PDOException $e)
{
  echo '<div class="alert alert-danger fade in"><button type="button" class="close close-alert" data-dismiss="alert" aria-hidden="true">×</button>Database error!Please check the input!</div>';
  $e->getMessage();
}

$conn = null;
?>

</body>
 <script type="text/javascript">

      //Chiamata LOAD LEVEL
      // var data = new FormData();
      // data.append("data", 0);
      // var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
      // xhr.open("post", "load_level_x.php", true);
      // xhr.send(data);

      //Chiamata LEADERBOARD
      




        </script>
</html>
