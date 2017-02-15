
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Registration Page</title>

  <!-- Bootstrap -->
  <link href="../css/bootstrap.css" rel="stylesheet">
  <link href="../css/custom.min.css" rel="stylesheet">
  <link href="../css/index.css"" rel="stylesheet">
  <link rel="stylesheet" href="../fonts/font-awesome/css/font-awesome.min.css">
  <link href="../css/login.css" rel="stylesheet">

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

<body>
<div class="container">
  <div class="page-header" id="banner">
    <div class="row">
      <div class="col-lg-8 col-md-7 col-sm-6">
        <h1>The Barbarian's Desert</h1>
        <p class="lead">A meta-Javascript game adventure to learn programming.</p>
        <p class="lead">To begin playing, register!</p>

      </div>
    </div>
    <!-- LOGIN FORM -->
    <div id="loginform" class="text-center center-form" style="padding:20px 0">
      <div id="logo" class="logo">Registration</div>
      <!-- Main Form -->
      <div class="login-form-1">
        <form name="registration" id="registration" method="POST">
          <div class="login-form-main-message"></div>
          <div class="main-login-form">
            <div class="login-group">
              <div class="form-group">
                <label for="lg_username" class="sr-only">Username</label>

                <input id="username" type="text" name="username" class="form-control">
                <span class="error"><p id="username_error"></p></span>

              </div>
              <div class="form-group">
                <label for="lg_password" class="sr-only">Password</label>

                <input id="password" type="password" name="password" class="form-control"/>
            <span class="error"><p id="password_error"></p></span>
              </div>
            </div>
              <div class="form-group">
            <input  type="submit" name="btnLogin" class="btn btn-primary" value="Register"><i class="fa fa-chevron-right"></i></input>
            </div>
          </div>
          <div id="etc-logo" class="etc-login-form">
           <!--  <a id="newuser" type="button" class="btn btn-default btn-lg navbar-btn text-center" href="registration.php">
              <span id="spanUser">New user? Create new account</span><br>
            </a> -->

          </div>
        </form>
      </div>
      <!-- end:Main Form -->
    </div>
    <footer>
      <div class="row">
        <div class="col-lg-12">
          <p>Made by Gianluca Monica, Margherita Donnici and Maxim Gaina.</p>
          <p>Human-Computer Interaction course project, University of Bologna, 2017 </p>
        </div>
      </div>
    </footer>
  </div>

</div>


</body>



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

          // $_SESSION['loggedin'] = true;
          // $_SESSION['loggedinUser'] = $username;
        header('Location: login.php');
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
