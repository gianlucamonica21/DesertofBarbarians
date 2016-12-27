$(document).ready(function(){
	var code = $("#editor")[0];
	var editor = CodeMirror.fromTextArea(code, {
		lineNumbers : true,
		mode : "javascript"
	});

	$('#submitButton').click(function(){
		editor.save();
		alert("CLICKED");
		//var data_url = "data:text/javascript;charset=utf-8;base64," + $.base64.encode(code);
		//document.getElementById("result").src = data_url;
		var resultFrame = document.getElementById("result");
      	var iWind = resultFrame.contentWindow;   // the iframe's window
     	resultFrame = iWind.eval(code);

	});

});

