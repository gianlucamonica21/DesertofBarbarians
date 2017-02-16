  var contHint = 0;

  $(document).ready(function() {
    console.log(document.body.getAttribute("level"));
  // Initialize tooltips
  $('.btn').tooltip();

  // Load level instructions
  var currentLevel = document.body.getAttribute("level");
  var filepath = "js/levels/" + currentLevel + "/dialogues.json";
  $.getJSON(filepath, function(result) {

    msgString = result.generalMsg;
    writeChatMessage(msgString, "generalMsg",false);
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
      // CHAT ANIMATIOND
      writeChatMessage("Syntax errors found. Please submit input again.","consoleMsg",false);
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
      writeChatMessage("Applied code update.", "consoleMsg",false);
    }
  });

  // RESTART GAME BUTTON
  $('#nextButton').click(function() {



      // // Code to reload and reupdate the level
      var stringa;
      var oReq = new XMLHttpRequest(); //New request object
      oReq.onload = function() {
        stringa = this.responseText;
      };
      oReq.open("get", "DBConnection/load_player.php", true);
      oReq.send();

      // // Carica dati del prossimo livello
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
      xhr.onreadystatechange = function () {
       if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {

       }
     };
      xhr.send(data);


     location.reload();

   });

  // HINT BUTTON

  $('#hintButton').click(function() {
    contHint++;
    console.log("numero  aiuti: " + contHint);
    var currentLevel = document.body.getAttribute("level");
    var filepath = "js/levels/" + currentLevel + "/dialogues.json";
    $.getJSON(filepath, function(result) {
      msgString = result.soldierMsg;
      writeChatMessage(msgString,"soldierMsg",false);
    });
  });

  // REFRESH BUTTON
  $('#refreshButton').click(function() {

    $("#reset-modal-title").text('ATTENTION!');
      $("#modal-textreset").text('Do you want to reset your updates?');
      $("#image-modal").attr('src', '');
      $("#resetModal").modal('show');

    var currentLevel = document.body.getAttribute("level");
    var filepath = "js/levels/" + currentLevel + "/level" + currentLevel + ".js";
    editor.off('beforeChange',readOnlyLinesHandler);




    $("#closeModalY").click(function() {

    $.get(filepath, function(data) {
      editor.setValue(data);
          // Get the read only lines for this level and set handler
          $.getJSON('getReadOnlyLines.php', function(data) {
            editor.on('beforeChange', readOnlyLinesHandler);
            $.each(data, function(key, val) {
              readOnlyLinesArray[key] = parseInt(val);
           //   console.log("rolarray", readOnlyLinesArray);
           window.editor.addLineClass(readOnlyLinesArray[key], 'background', 'disabled');

         });
          });
        });

      $("#resetModal").modal('hide');
    });

    $("#closeModalN").click(function() {


      $("#resetModal").modal('hide');
    });









  });
});



// PLAY GAME BUTTON
$('#playButton').click(function() {

  startLevel();
  $('#playButton').addClass('disabled');
  $('#pauseButton').removeClass('disabled');


});


// PAUSE GAME BUTTON
$('#pauseButton').click(function() {

  drawStopMessage();
  $('#pauseButton').addClass('disabled');
  $('#playButton').removeClass('disabled');




});




// EVALUATE BUTTON
$('#evaluateButton').click(function() {
  if (!($('#evaluateButton').hasClass('disabled'))) {
    finishedCoding = (new Date()).getTime();
    difference = (finishedCoding - startedCoding) / 1000;
    console.log("Hai impiegato " + (difference) + " secondi per fornire la soluzione");

 var result = userSolutionChecker();

 //var result = {
  //passed: false,
  //msg: "DEBUG"
//};
try {
      // scrittura su file modificato nell'editor
      var data = new FormData();
      data.append("data", window.editor.getValue());
      var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
      xhr.open('post', 'SaveToFile.php', true);
      xhr.send(data);

    } catch (err) {
      console.log("Cannot save file.");
    }

    if (result.passed == true) {




      writeChatMessage(result.msg,"generalMsg",true);
      // Unlock badges (if necessary)
      var unlockedbadgeQueue = [];
      unlockedbadgeQueue = badge();
      console.log("unlockedbadgeQueue LENGTH: " + unlockedbadgeQueue.length);


      if( level == 1 && score == 0){

         startIntroLv1();
      }
      // else
      // if( level >= 2 && level <=8){
      //    startLevelPassed();
      // }
       if(level == 9){
        gameOver();
      }
      else{
       document.getElementById('nextButton').style.visibility='visible';

     }

      for(var i = 0; i < unlockedbadgeQueue.length; i++) {
      var data = new FormData();
      data.append("data", unlockedbadgeQueue[i]);
      var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
      xhr.open("post", "DBConnection/add_badge.php", true);
      xhr.send(data);
    }






    } else {
      // Level not passed
      startLevelNotPassed();
      writeChatMessage(result.msg, "generalMsg",false);
    }
  } else {
      // If user clicks on validate before execute
      msgString = "Pssst... Remember to execute code before validating! The General doesn't want us to submit anything's that's not been tested, as there have been ... incidents ... in the past.";
      writeChatMessage(msgString,"soldierMsg",false);
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

function writeChatMessage(msgString, sender, goToNextLevel){
  $('.chat-thread').append(
    $('<li>')
    .addClass(sender)
    .typed({
      strings: [msgString],
      typeSpeed: 5,
      callback: function() {
        $('.chat-thread').scrollTop($('.chat-thread')[0].scrollHeight);
      }
    })
    );
  $('.chat-thread').scrollTop($('.chat-thread')[0].scrollHeight);
}
