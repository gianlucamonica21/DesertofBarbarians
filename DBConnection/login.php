<?php
// If user is already logged in, redirect to index.php
session_start();
if (isset($_SESSION['loggedinUser'])) {
  header("location: ../index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Login Page</title>

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
              <p class="lead">To begin playing, please login or register!</p>

            </div>
          </div>
          <!-- LOGIN FORM -->
          <div id="loginform" class="text-center center-form" style="padding:20px 0">
            <div id="logo" class="logo">Login</div>
            <!-- Main Form -->
            <div class="login-form-1">
              <form id="login-form" class="text-left">
                <div class="login-form-main-message"></div>
                <div class="main-login-form">
                  <div class="login-group">
                    <div class="form-group">
                      <label for="lg_username" class="sr-only">Username</label>
                      <input type="text" class="form-control" id="lg_username" name="lg_username" placeholder="username">
                    </div>
                    <div class="form-group">
                      <label for="lg_password" class="sr-only">Password</label>
                      <input type="password" class="form-control" id="lg_password" name="lg_password" placeholder="password">
                    </div>
                  </div>
                  <button type="submit" id="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
                </div>
                <div id="etc-logo" class="etc-login-form">
                  <a id="newuser" type="button" class="btn btn-default btn-lg navbar-btn text-center" href="registration.php">
                    <span id="spanUser">New user? Create new account</span><br>
                  </a>

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
      </body>
      <script type="text/javascript" src="../js/loginScript.js"></script>
      </html>
      <script type="text/javascript">


       //Chiamata LOAD PLAYER
      
      var stringa;
      var oReq = new XMLHttpRequest(); //New request object
      oReq.onload = function() {
        stringa = this.responseText;
      };
      oReq.open("get", "load_player.php", true);
      oReq.send();
      console.log("RISULTATO  CHIAMATA da editor.js (di load_player.php):" + stringa);
       
      //Chiamata LOAD LEVEL
      var data = new FormData();
      data.append("data", 0);
      var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
      xhr.open("post", "load_level_x.php", true);
      xhr.send(data);

      




</script>
