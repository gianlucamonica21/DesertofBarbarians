  var stoppedGame = false;
  // set editor by CodeMirror function
  var editor = 
  CodeMirror.fromTextArea(document.getElementById("editor"),{
    mode: "javascript",
    lineNumbers: true,
    styleSelectedText: true,
    lineWrapping: false,
    viewportMargin: Infinity
  });
  
  $.ajax({
    url: 'getLevel.php',
    type: 'GET',
    success: function(result){
      loadLevelJs(result);
    }
  });

  var startedCoding;
  editor.on('change',function(cm,change) {
    // if ( ~readOnlyLines.indexOf(change.from.line) ) {
    //   change.cancel();
    // }
    // alert("stai scrivendo");
    drawStopMessage();
    startedCoding = (new Date()).getTime();
    //console.log("Hai iniziato a scrivere :" + startCoding);
    stoppedGame = true;
    $('#returnButton').removeClass("disabled");
  });

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
    alert("RISULTATO  CHIAMATA da index :" + stringa);

    function loadLevelJs(path){
      var xhr = new XMLHttpRequest();
      var widgets = [];

      for (var i = 0; i < widgets.length; ++i)
        window.editor.removeLineWidget(widgets[i]);

      widgets.length = 0;

      xhr.open("GET", path, true);
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
    }