  var stoppedGame = false;
  var widgets = [];
  var readOnlyLinesArray = [];

  // set editor by CodeMirror function
  var editor =
  CodeMirror.fromTextArea(document.getElementById("editor"), {
    mode: "javascript",
    lineNumbers: true,
    styleSelectedText: true,
    lineWrapping: true,
    viewportMargin: Infinity
  });

  $.ajax({
    url: 'getEditorCode.php',
    type: 'GET',
    success: function(result) {
      loadLevelJs(result);
    }
  });

  //var startedCoding;
  editor.setSize(750, 700);

  // Handler for when change happens in the editor
  editor.on('change', function(cm, change) {
    // Pause the game


    drawStopMessage();
    //startedCoding = (new Date()).getTime();
    stoppedGame = true;
    $('#returnButton').removeClass("disabled");
    $('#evaluateButton').addClass("disabled");


    $('#pauseButton').addClass('disabled');
    $('#playButton').removeClass('disabled');
    // // Handler in case of insertion/deletion of a line
    if (change.origin != "setValue"){ //If the change is caused by loading the coading in the editor, the read-only lines remain the same
      lineChangeHandler(change);
    }
  });

  // Code to reload and reupdate the level
  /* var stringa;
  var oReq = new XMLHttpRequest(); //New request object
  oReq.onload = function() {
    stringa = this.responseText;
  };
  oReq.open("get", "DBConnection/load_player.php", true);
  oReq.send();
  */
  // Update level data
  $.post("DBConnection/load_level_x.php", 0);

  // Called after getting the path of the code to load
  function loadLevelJs(path) {
    var xhr = new XMLHttpRequest();

    // Reset read-only lines style
    for (var i = 0; i < widgets.length; ++i)
      window.editor.removeLineWidget(widgets[i]);

    widgets.length = 0;

    $.get(path, function(data){
          //Read the file content and set in the editor
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
        } );
  }

  var readOnlyLinesHandler = function(codemirror, change) {
    // Set read only lines
    if (~readOnlyLinesArray.indexOf(change.from.line)) {
      change.cancel();
    }
  }

  var lineChangeHandler = function(change) {
    if (change.to.line < change.from.line || change.to.line - change.from.line + 1 > change.text.length) {
        // A line has been deleted
        var numRemoved = change.to.line - change.from.line - change.text.length + 1;
     //   console.log("Deletion", numRemoved, "happened at line", change.from.line);
     for (i=0; i < readOnlyLinesArray.length; i++){
          // Decrement all the line numbers which are after the line where the deletion happened
          if(readOnlyLinesArray[i] > change.from.line){
            readOnlyLinesArray[i] = readOnlyLinesArray[i] - numRemoved;
          }
        }

    } else { // Insert/paste
      var numAdded = change.text.length - (change.to.line - change.from.line + 1);
  //      console.log("Insert/Paste", "new lines:", numAdded, "happened at line", change.from.line);
  for (i=0; i < readOnlyLinesArray.length; i++){
          // Increment all the line numbers which are after the line where the deletion happened
          if(readOnlyLinesArray[i] >= change.from.line){
            readOnlyLinesArray[i] = readOnlyLinesArray[i] + numAdded;
          }
        }
      }
    }
