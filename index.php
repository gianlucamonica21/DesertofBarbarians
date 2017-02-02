<?php
ini_set('display_errors', 1);
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

  $x = $_SESSION['loggedinUser'];  
} else {
  echo '<script type="text/javascript">alert("non sei loggato");</script>';
}

//include "dbconfig.php";
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
  

  //check the level of the user loggedin 

  $level_query = $conn->prepare("SELECT level from User join Level where login = :login ");
  $level_query->bindParam(':login', $x);
  $level_query->execute();
  $level_rows = $level_query->fetch();
  $level = $level_rows["level"];
  $_SESSION["level"] = $level;

}
catch(PDOException $e)
{
  echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
<script type="text/javascript">
  var x = "<?php echo $x;?>"
  var level = "<?php echo $level;?>"
  
//  document.getElementById("spanUser").textContent=;

  //alert("You are logged as " + x);
  //alert("With level " + level);
  
</script>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Barbarian's Desert</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/custom.min.css" rel="stylesheet">
  <link href="css/index.css"" rel="stylesheet">
  <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
  <link href="plugin/codemirror/lib/codemirror.css" rel="stylesheet">

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="plugin/codemirror/lib/codemirror.js"></script>
  <script type="text/javascript" src="plugin/codemirror/mode/javascript/javascript.js"></script>
  <script type="text/javascript" src="js/default.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jshint/r07/jshint.js"></script>
  

  
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body>
      <!-- NAVBAR -->
      <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
              <li>
                <button type="button" class="btn btn-default btn-lg navbar-btn text-center" data-toggle="modal" data-target="#profileModal">
                  <span class="glyphicon glyphicon-user" aria-hidden="true"></span><br> Profile
                </button> 
              </li>
              <li>
               <button type="button" class="btn btn-default btn-lg navbar-btn text-center" data-toggle="modal" data-target="#tutorialModal">
                <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span><br> How to play
              </button>  
            </li>

            <li>
              <button type="button" class="btn btn-default btn-lg navbar-btn text-center" data-toggle="modal" data-target="#levelsModal">
                <span class="glyphicon glyphicon-forward" aria-hidden="true"></span><br> Levels
              </button>
            </li>

            <li>
              <button type="button" class="btn btn-default btn-lg navbar-btn text-center" data-toggle="modal" data-target="#leaderboardModal">
                <span class="icon">&#xf091;</span><br> Leaderboard
              </button>
            </li>


          </ul>

          <ul class="nav navbar-nav navbar-right">
            <button type="button" class="btn btn-default btn-lg navbar-btn text-center">
              <span id="spanUser"><?php echo "Welcome ".$x;?> </span><br> Logout
            </button>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="page-header" id="banner">
        <div class="row">
          <div class="col-lg-8 col-md-7 col-sm-6">
            <h1>The Barbarian's Desert</h1>
            <p class="lead">A meta-Javascript game adventure to learn programming.</p>
          </div>
        </div>
        <div class="row">
         <!-- Game panel  -->
         <div class="col-lg-6 col-md-6 col-sm-7">
          <div class="panel panel-default">
            <div class="panel-body">

             <div class="row" id="mc-container">
              <canvas id="miscom" class="game center-block" width="510" height="460">
                <?php
              //load the correct level of the user
                switch ($level) {
                  case 1:
                  echo '<script src="js/levels/3/levelThree.js" type="text/javascript"></script>
                  <script src="js/levels/3/MissileCommand.js" type="text/javascript">
                  </script> 
                  <script type="text/javascript">  missileCommand(true);</script>' ;
                  break;
                  case 2:
                  echo '<script src="js/Levels/Two/levelTwo.js" type="text/javascript"></script>
                  <script src="js/Levels/Two/MissileCommand2.js" type="text/javascript">
                  </script> 
                  <script type="text/javascript">  missileCommand(true);</script>' ;
                  break;
                  case 3:
                  echo '<script src="js/Levels/Three/levelThree.js" type="text/javascript"></script>
                  <script src="js/Levels/Three/MissileCommand2.js" type="text/javascript">
                  </script> 
                  <script type="text/javascript">  missileCommand(true);</script>' ;
                  break;
                  case 4:
                  echo '<script src="js/Levels/Four/setSpeed.js" type="text/javascript"></script>
                  <script src="js/Levels/Four/MissileCommand2.js" type="text/javascript">
                  </script> 
                  <script type="text/javascript">  missileCommand(true);</script>' ;
                  break;
                  case 5:
                  echo '<script src="js/Levels/Five/setSpeed.js" type="text/javascript"></script>
                  <script src="js/Levels/Five/MissileCommand2.js" type="text/javascript">
                  </script> 
                  <script type="text/javascript">  missileCommand(true);</script>' ;
                  break;
                  case 6:
                  echo '<script src="js/Levels/Six/setSpeed.js" type="text/javascript"></script>
                  <script src="js/Levels/Six/MissileCommand2.js" type="text/javascript">
                  </script> 
                  <script type="text/javascript">  missileCommand(true);</script>' ;
                  break;
                  case 7:
                  echo '<script src="js/Levels/Seven/setSpeed.js" type="text/javascript"></script>
                  <script src="js/Levels/Seven/MissileCommand2.js" type="text/javascript">
                  </script> 
                  <script type="text/javascript">  missileCommand(true);</script>' ;
                  break;
                  case 8:
                  echo '<script src="js/Levels/Eight/setSpeed.js" type="text/javascript"></script>
                  <script src="js/Levels/Eight/MissileCommand2.js" type="text/javascript">
                  </script> 
                  <script type="text/javascript">  missileCommand(true);</script>' ;
                  break;
                  case 9:
                  echo '<script src="js/Levels/Nine/setSpeed.js" type="text/javascript"></script>
                  <script src="js/Levels/Nine/MissileCommand2.js" type="text/javascript">
                  </script> 
                  <script type="text/javascript">  missileCommand(true);</script>' ;
                  break;
                  case 10:
                  echo '<script src="js/Levels/Ten/setSpeed.js" type="text/javascript"></script>
                  <script src="js/Levels/Ten/MissileCommand2.js" type="text/javascript">
                  </script> 
                  <script type="text/javascript">  missileCommand(true);</script>' ;
                  break;

                }
                ?>
                
                Missile Command
              </canvas>
            </div>


          </div>
        </div>
      </div>
      <!-- Editor panel  -->
      <div class="col-lg-6 col-md-6 col-sm-7">
        <div class="panel panel-default">
          <div class="panel-heading">Editor</div>
          <div class="panel-body">
            <textarea id="editor"></textarea>
            <button  class="btn btn-default" id="submitButton">Execute</button>
            <button  class="btn btn-default" id="evaluateButton">Evaluate</button>

          </div>
        </div>

      </div>

    </div>
    <!-- Chat Panel  -->
    <div class="panel panel-default">
      <div class="panel-heading">Level 1</div>
      <div class="panel-body">
        Panel content
      </div>
    </div>
    <!-- PROFILE MODAL -->
    <div class="modal" id="profileModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Profile</h4>
          </div>
          <div class="modal-body">
            <div align="center">
              <div class="outter"><img src="http://lorempixel.com/output/cats-q-c-100-100-3.jpg" class="image-circle"/></div> 
              <h2>Username</h2>  
              <h3>RANK: Captain</h3>
              <div class="progress">
                <div class="progress-bar" style="width: 60%"></div>
              </div>
              <h4>Points to next rank: 7878</h4>
            </div>
            <div class="row">
              <div class="col-md-6 col-xs-6 follow line" align="center">
                <h3>125651 <br/> <span>POINTS</span>
                </h3>
              </div>
              <div class="col-md-6 col-xs-6 follow line" align="center">
                <h3>125651 <br/> <span>BADGES</span>
                </h3>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- TUTORIAL MODAL -->
    <div class="modal" id="tutorialModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">How to Play</h4>
          </div>
          <div class="modal-body">
            <p>One fine body…</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Got it!</button>
          </div>
        </div>
      </div>
    </div>

    <!-- LEVELS MODAL -->
    <div class="modal" id="levelsModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Levels</h4>
          </div>
          <div class="modal-body">
            <div class="btn-group">
              <a href="#" type="button" class="btn btn-primary">1</a>
            </div>
            <div class="btn-group">
              <a href="#" class="btn btn-primary">2</a>
            </div>
            <div class="btn-group">
              <a href="#" class="btn btn-primary">3</a>
            </div>
            <div class="btn-group">
              <a href="#" class="btn btn-primary">4</a>
            </div>
            <div class="btn-group">
              <a href="#" class="btn btn-primary">5</a>
            </div>
            <div class="btn-group">
              <a href="#" class="btn btn-primary disabled">6</a>
            </div>
            <div class="btn-group">
              <a href="#" class="btn btn-primary disabled">7</a>
            </div>
            <div class="btn-group">
              <a href="#" class="btn btn-primary disabled">8</a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Go!</button>
          </div>
        </div>
      </div>
    </div>


    <!-- LEADERBOARD MODAL -->
    <div class="modal" id="leaderboardModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Leaderboard</h4>
          </div>
          <div class="modal-body">
            <table class="table table-striped table-hover table-bordered ">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Badges</th>
                  <th>Points</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Column content</td>
                  <td>Column content</td>
                  <td>Column content</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Column content</td>
                  <td>Column content</td>
                  <td>Column content</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Column content</td>
                  <td>Column content</td>
                  <td>Column content</td>
                </tr>
              </tbody>
            </table> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <div class="row">
        <div class="col-lg-12">
          <p>Made by Gianluca Monica and Margherita Donnici.</p>
          <p>Human-Computer Interaction course project, University of Bologna, 2016 </p>
        </div>
      </div>
    </footer>

  </div>

  <script type="text/javascript">

  // set editor by CodeMirror function
  var editor = CodeMirror.fromTextArea(document.getElementById("editor"),{
   mode: "javascript",
   lineNumbers: true,
   styleSelectedText: true
 });



   	//read from the file.js and set the content in the Editor
    var xhr = new XMLHttpRequest();
    //TO DO -> implement a logical load of level and file
    var widgets = [];

    for (var i = 0; i < widgets.length; ++i)
      window.editor.removeLineWidget(widgets[i]);

    widgets.length = 0;
    xhr.open("GET", "js/levels/3/levelThree.js", true);
    xhr.onload = function (e) {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
		      //Read the file content and set in the editor
		      editor.setValue(xhr.responseText);
          //Check errors present in the content of the editor
          JSHINT(editor.getValue());

          // insert of the error comment in the editor at the right line
          for (var i = 0; i < JSHINT.errors.length; ++i) {
            var err = JSHINT.errors[i];
            if (!err) continue;
            var msg = document.createElement("div");
            var icon = msg.appendChild(document.createElement("span"));
            icon.innerHTML = "*---->";
            icon.className = "lint-error-icon";
            msg.appendChild(document.createTextNode(err.reason));
            msg.className = "lint-error";
            alert("errore di sintassi");
            widgets.push(window.editor.addLineWidget(err.line - 1, msg, {coverGutter: false, noHScroll: true})); 
          }
        } else {
          console.error(xhr.statusText);
        }
      }
    };
    xhr.onerror = function (e) {
      console.error(xhr.statusText);
    };
    xhr.send(null);

  </script>
</body>
</html>
