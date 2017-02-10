$(document).ready(function() {
  console.log(document.body.getAttribute("level"));
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
    for (var i = 0; i < widgets.length; ++i) {
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
      eval(newFunction.name + " = new Function('" + newFunction.args.join(',') + "', '" + newFunction.body + "')");

      // CHAT MSG

      $('.chat-thread').append(
        $('<li>')
        .addClass("consoleMsg")
        .typed({
          strings: ["Applied code update."],
          typeSpeed: 10
        })
      );
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
$('#evaluateButton').click(function() {
  if ($('#evaluateButton').prop('disabled', false)) {
    finishedCoding = (new Date()).getTime();
    difference = (finishedCoding - startedCoding) / 1000;
    alert("Hai impiegato " + (difference) + " secondi per fornire la soluzione");
    var result = userSolutionChecker();
    try {

      
      // scrittura su file modificato nell'editor
      var data = new FormData();
      data.append("data", window.editor.getValue());
      var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
      xhr.open('post', 'SaveToFile.php', true);
      xhr.send(data);

    } catch (err) {}

    if (result.passed == true) {

      $('.chat-thread').append(
        $('<li>')
        .addClass("generalMsg")
        .typed({
          strings: ["Great! Everything works again! Are you ready for the next mission?"],
          typeSpeed: 10
        })
      );

      var data = new FormData();
      data.append("data", difference);
      var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
      xhr.open("post", "DBConnection/nextlevel.php", true);
      xhr.send(data);

      var data = new FormData();
      data.append("data", 0);
      var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
      var stringa;
      xhr.onload = function() {
        stringa = this.responseText;
      };
      xhr.open("post", "DBConnection/load_level_x.php", true);
      xhr.send(data);
      setTimeout(function() {
        location.reload();
      }, 3000);

    } else {

      $('.chat-thread').append(
        $('<li>')
        .addClass("generalMsg")
        .typed({
          strings: [result.errorMsg],
          typeSpeed: 10
        })
      );
    }
  } else {
    $('.chat-thread').append(
      $('<li>')
      .addClass("soldierMsg")
      .typed({
        strings: ["Pssst... Remember to execute code before validating! The General doesn't want us to submit anything's that's not been tested, as there have been ... incidents ... in the past."],
        typeSpeed: 10
      }));
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
    // Escape the quotation marks
    currentLine = currentLine.replace(/'/g, "\\'");
    currentLine = currentLine.replace(/"/g, "\\\"");
    //Remove comments
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