$(document).ready(function() {

	var code = $(".codemirror-textarea")[0];
	var editor = CodeMirror.fromTextArea(code,{
		lineNumbers : true
	});

	//when form submitted
	$("#preview-form").submit(function(e){
		var value = editor.getValue();
		//alert("This is value: "  + value.length );
		if(value.length == 0){
			alert("Missing comment!");
		}
	});
});
