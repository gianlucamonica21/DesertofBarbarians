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
      // scrittura su file modificato nell'editor
      var data = new FormData();
      data.append("data", window.editor.getValue());
      var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
      xhr.open('post', 'SaveToFile.php', true);
      xhr.send(data);
      location.reload();
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

  // EVALUATE BUTTON

  $('#evaluateButton').click(function() {

    finishedCoding = (new Date()).getTime();
    difference = (finishedCoding - startedCoding) / 1000;
    alert("Hai impiegato " + (difference) + " secondi per fornire la soluzione");
    // If no syntax errors are found, check solution
    try {
      var test = false; //userSolutionChecker();
      // scrittura su file modificato nell'editor
      var data = new FormData();
      data.append("data", window.editor.getValue());
      var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
      xhr.open('post', 'SaveToFile.php', true);
      xhr.send(data);
    } catch (err) {
      // var test = getTest();
    }

    if (test == true) {
      alert("Livello passato!");
      var data = new FormData();
      data.append("data", difference);
      var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
      xhr.open("post", "DBConnection/nextlevel.php", true);
      xhr.send(data);

      // // Query to update the level of the user
      // var stringa;
      // var oReq = new XMLHttpRequest(); //New request object
      // oReq.onload = function() {
      //   //This is where you handle what to do with the response.
      //   //The actual data is found on this.responseText
      //   stringa = this.responseText; //Will alert: 42
      // };
      //
      // oReq.open("get", "DBConnection/nextlevel.php", false);
      // oReq.send(data);

      //Query to update the level of the user
      // var stringa;
      // var oReq = new XMLHttpRequest(); //New request object
      // oReq.onload = function() {
      //   //This is where you handle what to do with the response.
      //   //The actual data is found on this.responseText
      //   stringa = this.responseText; //Will alert: 42
      // };
      // oReq.open("post", "DBConnection/nextlevel.php", false);
      // oReq.send(difference);
      // alert("RISULTATO PRIMA CHIAMATA da defalut.js : "+ stringa);

      //Code to reload and reupdate the level
      var stringa;
      var oReq = new XMLHttpRequest(); //New request object
      oReq.onload = function() {
        //This is where you handle what to do with the response.
        //The actual data is found on this.responseText
        stringa = this.responseText; //Will alert: 42
      };
      oReq.open("get", "DBConnection/load_level.php", false);
      //                               ^ block the rest of the execution.
      //                                 Don't wait until the request finishes to
      //                                 continue.
      oReq.send();
      alert("RISULTATO SECONDA CHIAMATA da default.js :" + stringa);


    //  $('.chat-thread').empty();
    location.reload();
  } else {

    $('.chat-thread').append(
      $('<li>')
      .addClass("generalMsg")
      .typed({
        strings: ["This is not working!"],
        typeSpeed: 10
      })
      );

  };

});

});