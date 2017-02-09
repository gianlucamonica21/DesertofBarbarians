$(document).ready(function() {

  // Initialize tooltips
  $('.btn').tooltip();

  // Load level instructions
  var currentLevel = document.body.getAttribute("level");
  var filepath = "js/levels/" + currentLevel + "/dialogues.json";
  $.getJSON(filepath, function(result) {

    msgString = result.generalMsg;

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

  $('#submitButton').click(function() {
    // Remove old syntax errors
    for (var i = 0; i < widgets.length; ++i){
      window.editor.removeLineWidget(widgets[i]);
    }
    widgets.length = 0;
    //Check errors present in the content of the editor
    JSHINT(editor.getValue());
    // insert of the error comment in the editor at the right line
    if (JSHINT.errors.length > 0) {
      // If syntax errors are found, display them
      for (var i = 0; i < JSHINT.errors.length; ++i) {
        var err = JSHINT.errors[i];
        // if (!err) continue;
        var msg = document.createElement("div");
        var icon = msg.appendChild(document.createElement("span"));
        icon.className = "lint-error-icon";
        msg.appendChild(document.createTextNode(err.reason));
        msg.className = "lint-error";
        widgets.push(window.editor.addLineWidget(err.line - 1, msg, {
          coverGutter: false,
          noHScroll: true
        }));
      }
      // CHAT ANIMATION
      $('.chat-thread').append(
        $('<li>')
        .addClass("consoleMsg")
        .typed({
          strings: ["Syntax errors found. Please submit input again."],
          typeSpeed: 10
        })
        );
    } else {
      $('#evaluateButton').removeClass("disabled");
      // Save user code to file
      var data = new FormData();
      data.append("data", window.editor.getValue());
      var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
      xhr.open('post', 'SaveToFile.php', true);
      xhr.send(data);
      // Inject code inside the game
      var newFunction = parseCode(window.editor.getValue());
      console.log(newFunction.name + " = new Function('" + newFunction.args.join(',') +"', '" + newFunction.body +"')");
      eval(newFunction.name + " = new Function('" + newFunction.args.join(',') +"', '" + newFunction.body +"')");

    //  location.reload();
      //startLevel();
    }
  });

  // RESTART GAME BUTTON
  $('#returnButton').click(function() {
    //nextFrame();
    if (stoppedGame) {
      startLevel();
      stoppedGame = false;
      $('#returnButton').addClass("disabled");
    }
  });

  // HINT BUTTON

  $('#hintButton').click(function() {
    var currentLevel = document.body.getAttribute("level");
    var filepath = "js/levels/" + currentLevel + "/dialogues.json";
    $.getJSON(filepath, function(result) {
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

  // REFRESH BUTTON
  $('#refreshButton').click(function() {

    var currentLevel = document.body.getAttribute("level");
    var filepath = "js/levels/" + currentLevel + "/level" + currentLevel + ".js";
    $.get(filepath, function(data) {
      editor.setValue(data);
    });

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
    alert("RISULTATO SECONDA CHIAMATA da default.js (di Load_level.php) :" + stringa);

    location.reload();
  }
  else {
    $('.chat-thread').append(
      $('<li>')
      .addClass("generalMsg")
      .typed({
        strings: ["This is not working! Try again!"],
        typeSpeed: 10
      })
      );
  }
});

function parseCode(code) {
  // Create an array where each element is one line of the code
  var lines = code.split("\n");

  // Get function name
  var words = lines[0].split(" ");
  var functionName = words[words.indexOf('=') - 1]; // The name will be the element before "="

  // Get function arguments
  // First split after "(". then after ")", then with "," 
  var arguments = code.split('(')[1].split(')')[0].split(',');

  // Remove first line with function name (we don't need it anymore)
  lines.shift();

  var codeLines = [];

  while (lines[0].indexOf('};') === -1) {
    // Do this for each line until the line containing the closing curly brackets
    var currentLine = lines.shift();
    //Remove comments
    currentLine = currentLine.replace(/'/g, "\\'");
    currentLine = currentLine.replace(/"/g, "\\\"");
    currentLine = currentLine.replace(/(\/\*[\w\'\s\r\n\*]*\*\/)|(\/\/[\w\s\']*)|(\<![\-\-\s\w\>\/]*\>)/g, "");
    codeLines.push(currentLine);
  }
  var lineCount = codeLines.length;
  var body = codeLines.join(" ");

  return {
    name: functionName,
    args: arguments,
    body: body,
    numLines: lineCount
  };
}