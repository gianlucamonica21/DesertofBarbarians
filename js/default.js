$(document).ready(function(){

  // Load level instructions
  var currentLevel = document.body.getAttribute("level");
  var filepath = "js/levels/" + currentLevel + "/dialogues.json";
  $.getJSON( filepath, function(result) {

    msgString = result.generalMsg;
    $('.chat-thread').empty();
    $('.chat-thread').append(
      $('<li>')
      .addClass("generalMsg")
      .typed({
        strings: [msgString],
        typeSpeed: 10
      })

      );
  });

  var finishedCoding;


// EXECUTE BUTTON
$('#submitButton').click(function(){

  // scrittura su file modificato nell'editor
  var data = new FormData();
  data.append("data" , window.editor.getValue());
  var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
  xhr.open( 'post', 'SaveToFile.php', true);
  xhr.send(data);
  location.reload();
  //startLevel();

});

// RESTART GAME BUTTON
$('#returnButton').click(function(){
    //nextFrame();
    if(stoppedGame){
     startLevel();
     stoppedGame = false;
     $('#returnButton').addClass("disabled");
   }
 });

// HINT BUTTON

$('#hintButton').click(function(){
  var currentLevel = document.body.getAttribute("level");
  var filepath = "js/levels/" + currentLevel + "/dialogues.json";
  $.getJSON( filepath, function(result) {
    msgString = result.soldierMsg;
    $('.chat-thread').append(
      $('<li>')
      .addClass("soldierMsg")
      .typed({
        strings: [msgString],
        typeSpeed: 10
      })
      );
  });
});

// EVALUATE BUTTON
$('#evaluateButton').click(function(){
   finishedCoding = (new Date()).getTime();
   difference = (finishedCoding - startedCoding) / 1000;
   alert("Hai impiegato " + (difference) + " secondi per fornire la soluzione");

 try {
   var test = true; //userSolutionChecker();
   // scrittura su file modificato nell'editor
   var data = new FormData();
   data.append("data" , window.editor.getValue());
   var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
   xhr.open( 'post', 'SaveToFile.php', true);
   xhr.send(data);
   location.reload();
  }
  catch(err) {
        // var test = getTest();
  }

  if (test == true) {
    alert ("Livello passato!");
    var data = new FormData();
    data.append("data" , difference);
    var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
    xhr.open("post", "DBConnection/nextlevel.php", true);
    xhr.send(data);

    //Code to reload and reupdate the level
    var stringa;
    var oReq = new XMLHttpRequest(); //New request object
    oReq.onload = function() {
      //This is where you handle what to do with the response.
      //The actual data is found on this.responseText
      stringa = this.responseText; //Will alert: 42
    };

    oReq.open("get", "DBConnection/load_level.php", false);
    oReq.send();
    alert("RISULTATO SECONDA CHIAMATA da default.js :" + stringa);

    location.reload();
  }
  else
    alert("Valore sbagliato: riprova ancora");
});
});
