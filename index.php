<?php
session_set_cookie_params(86400);
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $current_player = $_SESSION['loggedinUser'];  
} else {
  header("location: DBConnection/loginPage.php");
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
  // LOAD LEVEL
  if($_SESSION["staticallyLevel"] === false){
    echo '<script>alert("sono dentro");</script>';
  $level_query = $conn->prepare("SELECT MAX(level) AS maxlevel FROM Campaign WHERE login= :login");
  $level_query->bindParam(':login', $current_player);
  $level_query->execute();
  $level_rows = $level_query->fetch();
  $level = $level_rows["maxlevel"];
  $_SESSION["level"] = $level;
  }
  // if(!empty($current_player)){
  //   $user_query = $conn->prepare("SELECT * FROM User WHERE login= :login");
  //   $user_query->bindParam(':login', $current_player);
  //   $user_query->execute();
  //   $user_rows = $user_query->fetch();
  //   $total_score = $user_rows["score"];
  //   $_SESSION['totalScore'] = $total_score;
  //   // Estrai grado
  //   $grade_query = $conn->prepare("SELECT * FROM Graduated WHERE login= :login");
  //   $grade_query->bindParam(':login', $current_player);
  //   $grade_query->execute();
  //   $grade_rows = $grade_query->fetch();
  //   $grade = $grade_rows["grade"];
  //   $_SESSION['userGrade'] = $grade;

  //   // Estrai massimo livello completato dal giocatore
  //   $level_query = $conn->prepare("SELECT MAX(level) AS maxlevel FROM Campaign WHERE login= :login");
  //   $level_query->bindParam(':login', $current_player);
  //   $level_query->execute();
  //   $level_rows = $level_query->fetch();
  //   $max_level = $level_rows["maxlevel"];
  //   $_SESSION['maxLevel'] = $max_level;

  //   /* Estrai lo score dentro tale livello, se l'utente non lo ha mai completato
  //     allora lo score sarà zero */
  //   $score_query = $conn->prepare("SELECT score FROM Campaign WHERE login= :login AND level= :level");
  //   $score_query->bindParam(':login', $current_player);
  //   $score_query->bindParam(':level', $max_level);
  //   $score_query->execute();
  //   $score_row = $score_query->fetch();
  //   $max_level_record_score = $score_row["score"];
  //   $_SESSION['maxCurrentLevelScore'] = $max_level_record_score;

  //   // Estrai le righe non modificabili per il massimo livello
  //   $constrows_query = $conn->prepare("SELECT * FROM ConstRow WHERE level= :level");
  //   $constrows_query->bindParam(':level', $max_level);
  //   $constrows_query->execute();
  //   $constrows_rows = $constrows_query->fetchAll();
  //   foreach ($constrows_rows as $constrow) {
  //     /* L'array constrows conterrà i numeri di tutte le righe costanti
  //        per il livello caricato dopo il login */
  //     $constrows[] = $constrow["row"];
  //   }

  //   // Estrai tutti gli achievement (o badge) mai guadagnati dal giocatore
  //   $achievements_query = $conn->prepare("SELECT * FROM Achieved WHERE login= :login");
  //   $achievements_query->bindParam(':login', $current_player);
  //   $achievements_query->execute();
  //   $achievements_rows = $achievements_query->fetchAll();
  //   foreach ($achievements_rows as $achievements_row) {
  //     /* L'array achievements conterrà i codici di tutti i badges mai
  //        guadagnati dall'utente appena loggato */
  //     $achievements[] = $achievements_row["achievement"];
  //   }


  //  }  

  //   if($grade_rows > 0 and
  //       $level_rows > 0 and
  //       $constrows_rows > 0 and
  //       $achievements_rows > 0) {
  //         echo '<script>alert("Query done!")</script>';
  //   }



}
catch(PDOException $e)
{
  echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
<script type="text/javascript">
  var x = "<?php echo $current_player;?>"
  var level = "<?php echo $level;?>"
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
  <link href="css/chat.css"" rel="stylesheet">
  <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
  <link href="plugin/codemirror/lib/codemirror.css" rel="stylesheet">

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="plugin/codemirror/lib/codemirror.js"></script>
  <script type="text/javascript" src="plugin/codemirror/mode/javascript/javascript.js"></script>
  <script type="text/javascript" src="js/default.js"></script>
  <script type="text/javascript" src="js/typed.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jshint/r07/jshint.js"></script>
  

  
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body level = <?php echo $_SESSION['level']?> >
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
            <a type="button" class="btn btn-default btn-lg navbar-btn text-center" href="logout.php">
              <span id="spanUser">Welcome <?php echo $current_player ?> !</span><br> Logout
            </a>
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
          <!-- Editor panel  -->
          <div class="col-lg-6 col-md-6 col-sm-7">
            <div class="panel panel-default">
              <div class="panel-heading">Editor</div>
              <div class="panel-body">
                <textarea id="editor"></textarea>
                <button  class="btn btn-danger" id="submitButton"><i class="fa fa-play" aria-hidden="true"></i></button>
                <button  class="btn btn-success" id="evaluateButton"><i class="fa fa-check" aria-hidden="true"></i></button>
                <button  class="btn btn-default disabled" id="returnButton">Restart Game</button>
                <button  class="btn btn-warning" id="refreshButton"><i class="fa fa-undo" aria-hidden="true"></i></button>
                <button  class="btn btn-info" id="hintButton"><i class="fa fa-question" aria-hidden="true"></i></button>
              </div>
            </div>

          </div>
          <div class="col-lg-6 col-md-6 col-sm-7">
           <!-- Chat Panel  -->
           <div class="panel panel-default">
            <div class="panel-heading">Level <?php echo $level ?></div>
            <div class="panel-body">
              <div id="chat">               
                <ul class="chat-thread">
            <!-- <li class="generalMsg">Are we meeting today?</li>
                  <li class="soldierMsg">yes, what time suits you?</li>
                  <li class="consoleMsg">I was thinking after lunch, I have a meeting in the morning</li> -->
                </ul>
              </div>
            </div>
          </div>
          <!-- Game panel  -->
          <div >
            <div class="panel panel-default">
              <div class="panel-heading">Console</div>
              <div class="panel-body">

               <div class="row" id="mc-container">
                <canvas id="miscom" class="game center-block" width="510" height="460">
                  <?php
                // Load the correct level of the user

                // Convert current level number to string
                  $levelNumber = $_SESSION["level"];
                  $levelString = "$levelNumber";
                  if(file_exists("js/levels/".$levelString."/".$_SESSION["loggedinUser"].".js")) {
                  // Load user solution file
                    echo '<script src="js/levels/'.$levelString.'/'.$_SESSION["loggedinUser"].'.js" type="text/javascript"></script>';
                  } else {
                  // Load default file
                   echo '<script src="js/levels/'.$levelString.'/level'.$levelString.'.js" type="text/javascript"></script>';
                 }
                // Load base game
                 echo '<script src="js/levels/'.$levelString.'/MissileCommand.js" type="text/javascript"> </script>';
                // Start game
                 echo '<script type="text/javascript">  missileCommand(true); </script>'; 
                 ?> 

                 Missile Command
               </canvas>
             </div>
           </div>
         </div>
       </div>
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
        <div class="buttons">
          <div class="btn-group">
            <button   id="button1" class="btn btn-primary level-buttons">1</button>
          </div>
          <div class="btn-group">
            <button  id="button1" class="btn btn-primary level-buttons">2</button>
          </div>
          <div class="btn-group">
            <button id="button1" class="btn btn-primary level-buttons">3</button>
          </div>
          <div class="btn-group">
            <button id="button1" class="btn btn-primary level-buttons">4</button>
          </div>
          <div class="btn-group">
            <button id="button1" class="btn btn-primary level-buttons">5</button>
          </div>
          <div class="btn-group">
            <button id="button1" class="btn btn-primary level-buttons ">6</button>
          </div>
          <div class="btn-group">
            <button id="button1" class="btn btn-primary level-buttons ">7</button>
          </div>
          <div class="btn-group">
            <button id="button1" class="btn btn-primary level-buttons ">8</button>
          </div>
           <div class="btn-group">
            <button id="button1" class="btn btn-primary level-buttons ">9</button>
          </div>
        </div>
        <script type="text/javascript">
          // recuperare livello, selezionare, deselezionare correttamente i livelli
          var maxlevel;
          var oReq = new XMLHttpRequest(); //New request object
          oReq.onload = function() {
          //This is where you handle what to do with the response.
          //The actual data is found on this.responseText
          maxlevel = this.responseText; //Will alert: 42
        };
        oReq.open("get", "DBConnection/get_maxlevel.php", false);
          //                               ^ block the rest of the execution.
          //                                 Don't wait until the request finishes to 
          //                                 continue.
          oReq.send(); 
          alert("MaxLevel: " + maxlevel);

          var levelArr = document.getElementsByClassName("level-buttons");
          //alert(levelArr);

          for(var i=0; i<levelArr.length; i++)
          {
            if(i > maxlevel){
            levelArr[i].classList.add("disabled");
            }
          }

          $('.level-buttons').click(function(){
            if(!(this.hasClass("disabled"))){
            clickedLevel = this.textContent;
            alert("clicked " + clickedLevel);
            var data = new FormData();
            data.append("data" , clickedLevel);
            var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
            xhr.open( 'post', 'DBConnection/change_level.php', true);
            xhr.send(data);
            location.reload(); 
          }

           });

        </script>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <!--<button type="button" id="go_to_level" class="btn btn-primary">Go!</button>-->
        
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
        <p>Made by Gianluca Monica, Margherita Donnici and Maxim Gaina.</p>
        <p>Human-Computer Interaction course project, University of Bologna, 2017 </p>
      </div>
    </div>
  </footer>

</div>
<script type="text/javascript" src="js/editor.js"></script>
<noscript>You need to turn JavaScript on.</noscript>
</body>
</html>
