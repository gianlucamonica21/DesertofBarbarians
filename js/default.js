	$(document).ready(function(){
	// var code = $("#editor")[0];
	// var editor = CodeMirror.fromTextArea(code, {
	// 	lineNumbers : true,
	// 	mode : "javascript"
	// });
	
	 $('#submitButton').click(function(){


	 	  // scrittura su file modificato nell'editor
	 	  var data = new FormData();
          data.append("data" , window.editor.getValue());
          var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP"); 
          xhr.open( 'post', 'SaveToFile.php', true);
          xhr.send(data);
          location.reload();
     
   
	 });
		

});

