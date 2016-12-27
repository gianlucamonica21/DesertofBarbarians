$(document).ready(function(){
	var code = $("#editor")[0];
	var editor = CodeMirror.fromTextArea(code, {
		lineNumbers : true,
		mode : "javascript"
	});

	$('#submitButton').click(function(){
        var code = document.getElementById("editor").value;
		editor.save();
		var resultFrame = document.getElementById("result");
    	var iWind = resultFrame.contentWindow;   // the iframe's window
    	iWind.eval(code);
	});

});

