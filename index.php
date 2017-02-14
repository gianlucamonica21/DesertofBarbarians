<?php
session_set_cookie_params(86400);
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $current_player = $_SESSION['loggedinUser'];
} else {
  header("location: DBConnection/login.php");
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
}
catch(PDOException $e)
{
  echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
<script type="text/javascript">
  var clickedLevel;
  var clicked;
  var x = "<?php echo $current_player;?>";
  var level = "<?php echo $_SESSION['level'];?>";
  console.log("Sei al livello: " + level);
  var maxlevel = "<?php echo $_SESSION['maxLevel'];?>";
  console.log("Livello massimo: " + maxlevel);
 
  var ownedBadges = '<?php echo json_encode($_SESSION['achievementsId']);?>';
  console.log("Owned: " + ownedBadges);
  var top = '<?php echo $_SESSION['top'];?>';
  var champion = '<?php echo $_SESSION['isChampion'];?>';
</script>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title  >Barbarian's Desert</title>

  <!-- Bootstrap -->
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/custom.min.css" rel="stylesheet">
  <link href="css/index.css"" rel="stylesheet">
  <link href="css/chat.css"" rel="stylesheet">
  <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
  <link href="plugin/codemirror/lib/codemirror.css" rel="stylesheet">

  <!-- TUTORIAL -->
  <!-- <link href="intro.js-2.4.0/example/assets/css/bootstrap.min.css" rel="stylesheet"> -->
  <link href="intro.js-2.4.0/example/assets/css/demo.css" rel="stylesheet">
 <!--  <link href="intro.js-2.4.0/example/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
-->  <link href="intro.js-2.4.0/introjs.css" rel="stylesheet">





<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="plugin/codemirror/lib/codemirror.js"></script>
<script type="text/javascript" src="plugin/codemirror/mode/javascript/javascript.js"></script>
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
   <!--     <li>
        <a type="button" class="btn btn-default btn-lg navbar-btn text-center" data-toggle="modal" data-target="#profileModal" data-intro="Click in to look your profile features!">
          <span class="glyphicon glyphicon-user" aria-hidden="true"></span><br> Profile
        </a>
      </li> -->
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
              <button id="profileTutorial" type="button" class="btn btn-default btn-lg navbar-btn text-center" data-toggle="modal" data-target="#profileModal">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span><br> Profile
              </button>
            </li>
            <li>
             <button id="tutorialbutton" type="button" class="btn btn-default btn-lg navbar-btn text-center"  data-target="#tutorialModal"  href="" onclick="">
               <script type="text/javascript">

                 $("#tutorialbutton").click(function() {

                  javascript:
                  //introJs().
                  startIntro();
                });
              </script>
              <span class="glyphicon glyphicon-question-sign" aria-hidden="true" ></span><br> How to play
            </button>
          </li>

          <!-- <li>
            <button  id="levelsTutorial" type="button" class="btn btn-default btn-lg navbar-btn text-center" data-toggle="modal" data-target="#levelsModal" >
              <span class="glyphicon glyphicon-forward" aria-hidden="true"></span><br> Levels
            </button>
          </li> -->

          <li>
            <button id="leaderboardTutorial" type="button" class="btn btn-default btn-lg navbar-btn text-center" data-toggle="modal" data-target="#leaderboardModal" >
              <span class="icon">&#xf091;</span><br> Leaderboard
            </button>
          </li>


        </ul>

        <ul id="logoutTutorial" class="nav navbar-nav navbar-right">
          <li>
           <a  type="button" class="btn btn-default btn-lg navbar-btn text-center"  >
            <span ><?php echo "Level: ".$_SESSION['level']; ?></span>
          </a>
        </li>
        <li>

          <ul>
            <a id="displayscorerank" type="button" class="btn btn-default btn-lg navbar-btn text-center"  >
              <ul id="ul">
                <span id="spanUser"><?php echo $_SESSION["gradeType"];  ?>  &nbsp</span>

                <span> Score:  <?php echo intval($_SESSION["totalScore"]); ?> </span>
              </ul>
              <div id="progress-score2" class="progress">

                <div id="scorebar2" class="progress-bar" style="width:9 %"></div>
                <script type="text/javascript">

                  var total = <?php echo intval($_SESSION["totalScore"])?>;
                  var percent;
                  var diff;
                  if( total == 0){
                    percent = 100;
                  }
                  else
                    if( total <= 250)
                    {
                      diff = 250 - total;
                      percent = (100 * diff) / 250;
                    }else
                    if( total > 250 && total <= 500)
                    {
                      diff = 500 - total;
                      percent = (100 * diff) / 250;
                    }else
                    if( total > 500 && total <= 750)
                    {
                      diff = 750 - total;
                      percent = (100 * diff) / 250;
                    }else{
                      percent = 100;
                    }


                    document.getElementById("scorebar2").style="width:"+(100-percent)+"%";
                  </script>
                </div>
              </a>
            </ul>
          </li>
          <li>
            <a type="button" class="btn btn-default btn-lg navbar-btn text-center" href="logout.php" >
              <span id="spanUser">Welcome <?php echo $current_player ?>!</span><br> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>


  <div class="container">

    <div>
      <div class="col-md-12">

        <div id="progressbar" class="progress" >

         <div id="col1" class="one "></div>
         <div id="col2" class="two "></div>
         <div id="col3" class="three"></div>
         <div id="col4"  class="four"></div>
         <div id="col5"  class="five"></div>
         <div id="col6" class="six"></div>
         <div id="col7" class="seven"></div>
         <div id="col8" class="eight "></div>

         


         <div id="timebarlv1" class="progress-bar progress-bar-danger" style="width:11.1%">

           <span type="button"  class="level-buttons" id="textbarlv1">1</span>
         </div>

         <div id="timebarlv2" class="progress-bar progress-bar-danger" style="width:11.1%">
          <span class="level-buttons" id="textbarlv2">2</span>
        </div>
        <div id="timebarlv3" class="progress-bar progress-bar-danger" style="width:11.1%">
          <span class="level-buttons" id="textbarlv3">3</span>
        </div>
        <div id="timebarlv4" class="progress-bar progress-bar-danger" style="width:11.1%">
          <span class="level-buttons" id="textbarlv4">4</span>
        </div>
        <div id="timebarlv5" class="progress-bar progress-bar-danger" style="width:11.1%">
          <span class="level-buttons" id="textbarlv5">5</span>
        </div>
        <div id="timebarlv6" class="progress-bar progress-bar-danger" style="width:11.1%">
          <span class="level-buttons" id="textbarlv6">6</span>
        </div>
        <div id="timebarlv7" class="progress-bar progress-bar-danger" style="width:11.1%">
          <span class="level-buttons" id="textbarlv7">7</span>
        </div>
        <div id="timebarlv8" class="progress-bar progress-bar-danger" style="width:11.1%">
          <span  class="level-buttons" id="textbarlv8">8</span>
        </div>
        <div id="timebarlv9" class="progress-bar progress-bar-danger" style="width:11.1%">
          <span class="level-buttons" id="textbarlv9">9</span>
        </div>
        <script type="text/javascript">
          var levelArr = document.getElementsByClassName("level-buttons");
          // console.log("levelarr" + levelArr);
          // console.log("levelarr" + levelArr[0].textContent);
          for(var i=0; i<levelArr.length; i++)
          {
            if(i >= maxlevel){
              levelArr[i].classList.add("disabled");
            }
          }
          $('.level-buttons').click(function(){
            //clicked = true;
            if(!($(this).hasClass("disabled"))){

              clickedLevel = this.textContent;
              // alert("clickedLevel" + clickedLevel);
              //alert("clicked " + clickedLevel);
              //console.log("hai cliccato: " + clicked);
              var data = new FormData();
              data.append("data", clickedLevel);
              var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
              xhr.open("post", "DBConnection/load_level_x.php", true);
              xhr.send(data);
              location.reload();

            }
          });
        


      </script>
    </div>
  </div>
</div>
<div class="row">
  <!-- Editor panel  -->
  <div class="col-lg-5 col-md-8 col-sm-7">
    <div id="editorpanel" class="panel panel-default">
      <div  class="panel-heading">Editor</div>
      <div class="panel-body" >
        <textarea id="editor"></textarea>
        <button  class="btn btn-danger" id="submitButton" data-toggle="tooltip" data-placement="bottom" data-original-title="Execute" >
          <i id="submitButtonSymbol" class="fa fa-play" aria-hidden="true"></i>
        </button>
        <button  class="btn btn-success disabled" id="evaluateButton" data-toggle="tooltip" data-placement="bottom" data-original-title="Evaluate" >
          <i id="evaluateButtonSymbol" class="fa fa-check" aria-hidden="true"></i>
        </button>
        <button  class="btn btn-warning" id="refreshButton" data-toggle="tooltip" data-placement="bottom" data-original-title="Refresh" >
          <i id="refreshButtonSymbol" class="fa fa-undo" aria-hidden="true"></i>
        </button>
        <button  class="btn btn-info" id="hintButton" data-toggle="tooltip" data-placement="bottom" data-original-title="Ask for help" >
          <i id="hintButtonSymbol" class="fa fa-question" aria-hidden="true"></i>
        </button>
        <button  class="btn btn-info" id="docButton" data-toggle="tooltip" data-placement="bottom" data-original-title="Read the documentation" >
          <i id="docButtonSymbol" class="fa fa-book" aria-hidden="true"></i>
        </button>
              <!-- <button  class="btn btn-danger" id="submitButton" data-toggle="tooltip" data-placement="bottom" data-original-title="Execute" data-step="8" data-intro="Click here to execute your code!">
                <i class="fa fa-play" aria-hidden="true"></i>
              </button>
              <button  class="btn btn-success disabled" id="evaluateButton" data-toggle="tooltip" data-placement="bottom" data-original-title="Evaluate" data-step="9" data-intro="Click here to evaluate your code!">
                <i class="fa fa-check" aria-hidden="true"></i>
              </button>
              <button  class="btn btn-default disabled" id="returnButton">Restart Game</button>
              <script type="text/javascript"></script>
              <button  class="btn btn-warning" id="refreshButton" data-toggle="tooltip" data-placement="bottom" data-original-title="Refresh">
                <i class="fa fa-undo" aria-hidden="true"></i>
              </button>
              <button  class="btn btn-info" id="hintButton" data-toggle="tooltip" data-placement="bottom" data-original-title="Ask for help">
                <i class="fa fa-question" aria-hidden="true"></i>
              </button> -->
            </div>
          </div>

        </div>

        <div class="col-lg-6 col-md-2 col-sm-7" id="gamediv">

          <!-- Game panel  -->

          <div class="panel panel-default" id="gamepanel">
            <div class="panel-heading">Console</div>
            <div class="panel-body">

             <div class="row" id="mc-container" >
              <canvas id="miscom" class="game center-block" width="510" height="460" >
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
             <!--CONSOLE -->
             <div id="controller" class="col-lg-6 col-md-2 col-sm-7">

               <div class="panel-heading"></div>
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
              <!--  <div id="progressbar" class="progress" >
                <div id="myBar" class="progress-bar progress-bar-danger" style="width: 100%"></div>
              </div> -->
              <!-- <div id="controllerbody" class="panel-body">
                <button  class="btn btn-default disabled" id="returnButton" >Resume Game</button>
                <script type="text/javascript"></script>


              </div> -->






            </div>





            <!-- Chat Panel  -->
            <div class="col-lg-6 col-md-2 col-sm-7" id= "divchatmain" >
             <div class="panel panel-default" id="divchat">
              <div class="panel-heading">Chat</div>
              <div class="panel-body">
                <div id="chat" >
                  <ul class="chat-thread">
            <!-- <li class="generalMsg">Are we meeting today?</li>
                  <li class="soldierMsg">yes, what time suits you?</li>
                  <li class="consoleMsg">I was thinking after lunch, I have a meeting in the morning</li> -->
                </ul>
              </div>
            </div>
          </div>

        </div>

      </div>
      <!-- PROFILE MODAL -->
      <div id="profileModal" class="modal" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button  type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
              <h4  class="modal-title" >Profile</h4>
            </div>
            <div class="modal-body">
              <div align="center">
                <div class="outter"><img src="http://lorempixel.com/output/cats-q-c-100-100-3.jpg" class="image-circle"/></div>
                <h2><?php echo $current_player ?></h2>
                <h3><?php echo $_SESSION["gradeType"]?></h3>
                <div class="progress">
                  <div id="scorebar" class="progress-bar" style="width: %"></div>
                  <script type="text/javascript">

                    var total = <?php echo intval($_SESSION["totalScore"])?>;
                    var percent;
                    var diff;
                    if( total == 0){
                      percent = 100;
                    }
                    else
                      if( total <= 250)
                      {
                        diff = 250 - total;
                        percent = (100 * diff) / 250;
                      }else
                      if( total > 250 && total <= 500)
                      {
                        diff = 500 - total;
                        percent = (100 * diff) / 250;
                      }else
                      if( total > 500 && total <= 750)
                      {
                        diff = 750 - total;
                        percent = (100 * diff) / 250;
                      }else{
                        percent = 100;
                      }


                      document.getElementById("scorebar").style="width:"+(100-percent)+"%";
                    </script>
                  </div>
                  <script type="text/javascript">
                    var nowscore = <?php echo intval($_SESSION["totalScore"])?>;
                  </script>
                  <h4>
                    <?php
                    if ( intval($_SESSION["totalScore"]) == 0)
                    {
                      $zero = 250;
                      echo "Points to the next rank: ".$zero;
                    }
                    else
                      if( intval($_SESSION["totalScore"]) <= 250 )
                      {
                        echo "Points to the next rank: ".intval(250 - $_SESSION["totalScore"]);
                      }
                      else if
                        ( intval($_SESSION["totalScore"]) > 250 && intval($_SESSION["totalScore"]) <= 500)
                      {
                        echo "Points to the next rank: ".intval(500 - $_SESSION["totalScore"]);
                      }else
                      if( intval($_SESSION["totalScore"]) > 500 && intval($_SESSION["totalScore"]) <= 750 ){
                        echo "Points to the next rank: ".intval(750 - $_SESSION["totalScore"]);
                      }else
                      {
                        echo "You are at the max rank!";
                      }



                      ?>



                    </h4>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-xs-6 follow line" align="center">
                      <h3><?php echo intval($_SESSION["totalScore"]) ?> <br/>
                        <span>POINTS</span>
                      </h3>
                    </div>
                    <div class="col-md-6 col-xs-6 follow line" align="center">
                      <h3><?php echo $_SESSION['achievementsQty'];?> <br/> <span>BADGES</span>
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
                  <button id="howtoplay" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
          <!-- NOTIFICATION LEVEL MODAL -->
          <div class="modal" id="notificationModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 id="notification-modal-title" class="modal-title">BADGE!!</h4>
                </div>
                <div class="modal-body" style="text-align : center;">
                  <image id="image-modal" src=""  align="center"> </image>
                  <!-- src="img/general.png" -->
                  <p id="modal-text" ></p>
                </div>
                <div class="modal-footer">
                 <button type="button" id="closeModal" class="btn btn-primary" >Got it!</button>
               </div>
             </div>
           </div>
         </div>
         <script type="text/javascript">

    //$('#notificationModal').modal('toggle');
    // $('#notificationModal').modal('show');
    // $('#notificationModal').modal('hide');


  </script>

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
            <!-- <span   id="button1" class="btn btn-primary level-buttons">1</span>
          </div>
          <div class="btn-group">
            <span  id="button1" class="btn btn-primary level-buttons">2</span>
          </div>
          <div class="btn-group">
            <span id="button1" class="btn btn-primary level-buttons">3</span>
          </div>
          <div class="btn-group">
            <span id="button1" class="btn btn-primary level-buttons">4</span>
          </div>
          <div class="btn-group">
            <span id="button1" class="btn btn-primary level-buttons">5</span>
          </div>
          <div class="btn-group">
            <span id="button1" class="btn btn-primary level-buttons ">6</span>
          </div>
          <div class="btn-group">
            <span id="button1" class="btn btn-primary level-buttons ">7</span>
          </div>
          <div class="btn-group">
            <span id="button1" class="btn btn-primary level-buttons ">8</span>
          </div>
          <div class="btn-group">
            <span id="button1" class="btn btn-primary level-buttons ">9</span>
          </div> -->
        </div>

        <script type="text/javascript">

          var levelArr = document.getElementsByClassName("level-buttons");

          for(var i=0; i<levelArr.length; i++)
          {
            if(i >= maxlevel){
              levelArr[i].classList.add("disabled");
            }
          }
          $('.level-buttons').click(function(){
            //clicked = true;
            if(!($(this).hasClass("disabled"))){

              clickedLevel = this.textContent;
              //alert("clicked " + clickedLevel);
              //console.log("hai cliccato: " + clicked);
              var data = new FormData();
              data.append("data", clickedLevel);
              var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
              xhr.open("post", "DBConnection/load_level_x.php", true);
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
                <!-- <th>#</th> -->
                <th>Username</th>
                <th>Points</th>
                <th>Badges</th>
              </tr>
            </thead>
            <tbody id="leaderboardbody">

            </tbody>
          </table>
        </div>
        <script type="text/javascript">
          $('#leaderboardTutorial').click(function() {
            var leaderNames = '<?php  echo json_encode($_SESSION['leaderNames']); ?>';
            var leaderScores = '<?php  echo json_encode($_SESSION['leaderScores']); ?>';
            var leaderBadges = '<?php  echo json_encode($_SESSION['leaderBadges']); ?>';
            var number = '<?php  echo json_encode($_SESSION['NUMBER']); ?>';
            console.log("leadernames: " + leaderNames + "leaderScores: " + leaderScores + "leaderBadges: " + leaderBadges);

            $("#leaderboardbody").empty();
            for(var i = 0;i < number; i++){
              console.log("n: " + i);
              $("#leaderboardbody").append(
                $('<tr>')
                .attr('id','player' + i)
                );
              $("#player" + i).append(
                $('<td>')
                .text((JSON.parse(leaderNames)[i])),
                $('<td>')
                .text((JSON.parse(leaderScores)[i])),
                $('<td>')
                .text((JSON.parse(leaderBadges)[i]))
                );
            }
            clicked = false;
          });
        </script>
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
<script type="text/javascript" src="js/default.js"></script>
<script type="text/javascript" src="js/badge.js"></script>
<script type="text/javascript" src="intro.js-2.4.0/intro.js"></script>
<script type="text/javascript">

  function startIntro(){
    var intro = introJs();
    intro.setOptions({
      steps: [
      {
        intro: "WELCOME!!<br> "
      }
      ,

      {
        element: document.querySelector('#chat'),
        position: 'left',
        intro: "This is where you can read the messages with the instructions from the general or the soldier hint!"
      },
      {
        element: document.querySelector('#editorpanel'),
        intro: "This is where you code to fix the bugs!",
        position: 'right'
      },
      {
        element: document.querySelector('#gamepanel'),
        intro: 'This is the game, play to see your changes!',
        position: 'left'
      },
      {
        element: document.querySelector('#submitButton'),
        intro: 'Click here to update the game code!',
        position: 'top'
      },
      {
        element: document.querySelector('#evaluateButton'),
        intro: 'Click here to evaluate your code, if the solution is right you will go to the next level!',
        position: 'top'
      },
      {
        element: document.querySelector('#refreshButton'),
        intro: 'Click here to remove your last updates in the code!',
        position: 'top'
      },
      {
        element: document.querySelector('#hintButton'),
        intro: 'Click here to ask for help to the old programmer assistant!',
        position: 'top'
      },
      {
        element: document.querySelector('#docButton'),
        intro: 'Click here to read the surviving documentation!',
        position: 'top'
      },
      {
        element: document.querySelector('#returnButton'),
        intro: 'Click here to resume the game from the pause!',
        position: 'top'
      },
      {
        element: document.querySelector('#profileTutorial'),
        intro: 'Click here to view your statistics!',
        position: 'bottom'
      },
      {
        element: document.querySelector('#levelsTutorial'),
        intro: 'Click here to view the locked and unlocked levels!',
        position: 'bottom'
      },
      {
        element: document.querySelector('#leaderboardTutorial'),
        intro: 'Click here to view the leaderboard, check your ranking!',
        position: 'bottom'
      },
      {
        element: document.querySelector('#logoutTutorial'),
        intro: 'Click here to logout :(',
        position: 'bottom'
      },
      {
        element: document.querySelector('#tutorialbutton'),
        intro: 'Click here if you want to see the tutorial again!',
        position: 'bottom'
      }

      ]
    });
    intro.start();
  }

</script>
<script type="text/javascript">
    upgradeLevelBar();      
        function upgradeLevelBar(){
          var lmax = maxlevel;
          console.log("lmax"+lmax);
          for(var i=1; i<=9; i++){
            if( i >= 1 && i <= 3){
              document.getElementById("timebarlv"+i).style.backgroundColor="indianred";
              document.getElementById("col"+i).style.backgroundColor="indianred";
            }else
            if( i >= 4 && i <= 6){
              document.getElementById("timebarlv"+i).style.backgroundColor="steelblue";
              document.getElementById("col"+i).style.backgroundColor="steelblue";

            }else
            if( i >= 7 && i <= 9){
              document.getElementById("timebarlv"+i).style.backgroundColor="coral";
              if(i<9){
                document.getElementById("col"+i).style.backgroundColor="coral";
              }
            }
            if(i > lmax){
             document.getElementById("textbarlv"+i).style.color="#2c3e50";
             document.getElementById("timebarlv"+i).style.backgroundColor="beige";
             if(i<9){
              document.getElementById("col"+i).style.backgroundColor="beige";
            }
          }
        }
       };
</script>
<noscript>You need to turn JavaScript on.</noscript>
</body>
</html>
