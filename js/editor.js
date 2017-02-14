  var stoppedGame = false;
  var widgets = [];
  var readOnlyLinesArray = [];
  // Get read only lines array
  $.getJSON('getReadOnlyLines.php', function (data) {
    $.each(data, function(key, val) {
      readOnlyLinesArray[key] = val;
    });
  });

  
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

  var startedCoding;
  editor.setSize(750,700);
  editor.on('change', function(cm, change) {
  drawStopMessage();

    startedCoding = (new Date()).getTime();

    //console.log("Hai iniziato a scrivere :" + startCoding);
    stoppedGame = true;
    $('#returnButton').removeClass("disabled");
    $('#evaluateButton').addClass("disabled");


  });

  // Code to reload and reupdate the level
  var stringa;
  var oReq = new XMLHttpRequest(); //New request object
  oReq.onload = function() {
    stringa = this.responseText;
  };
  oReq.open("get", "DBConnection/load_player.php", true);
  oReq.send();

  var data = new FormData();
  data.append("data", 0);
  var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
  xhr.open("post", "DBConnection/load_level_x.php", true);
  xhr.send(data);

  function loadLevelJs(path) {
    var xhr = new XMLHttpRequest();

    for (var i = 0; i < widgets.length; ++i)
      window.editor.removeLineWidget(widgets[i]);

    widgets.length = 0;

    xhr.open("GET", path, true);
    xhr.onload = function(e) {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          //Read the file content and set in the editor
          editor.setValue(xhr.responseText);

          $.getJSON('getReadOnlyLines.php', function (data) {
            $.each(data, function(key, val) {
              readOnlyLinesArray[key] = val;
              editor.on('beforeChange',readOnlyLinesHandler);
              for (i=0;i<readOnlyLinesArray.length;i++){
                editor.addLineClass( readOnlyLinesArray[i], 'background', 'disabled');
              }
            });
          });
        } else {
          console.error(xhr.statusText);
        }
      }
    };
    xhr.onerror = function(e) {
      console.error(xhr.statusText);
    };
    xhr.send(null);
  }

  var readOnlyLinesHandler = function (codemirror, change) {
          // Set read only lines
          if ( ~readOnlyLinesArray.indexOf(change.from.line) ) {
            change.cancel();
          }
        }
