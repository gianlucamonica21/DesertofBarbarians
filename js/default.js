	$(document).ready(function(){
	// var code = $("#editor")[0];
	// var editor = CodeMirror.fromTextArea(code, {
	// 	lineNumbers : true,
	// 	mode : "javascript"
	// });

	// function readTextFile(file)
	// {
	//     var rawFile = new XMLHttpRequest();
	//     rawFile.open("GET", file);
	//     rawFile.onreadystatechange = function ()
	//     {
	//         if(rawFile.readyState === 4)
	//         {
	//             if(rawFile.status === 200 || rawFile.status == 0)
	//             {
	//                 var allText = rawFile.responseText;
	//                 editor.setValue(allText);
	//                 editor.save();
	//                 var code = document.getElementById("editor").value;	
	// 				console.log("code: " + code);	
	// 				var resultFrame = document.getElementById("result");
	// 			 	var iWind = resultFrame.contentWindow;   // the iframe's window
	// 			 	resultFrame = iWind.eval(code);
	//             }
	//         }
	//     }
	//     rawFile.send(null);
	// }

		

	// readTextFile("js/prova.js");
	
	 $('#submitButton').click(function(){


	 	  // scrittura su file modificato nell'editor
	 	  var data = new FormData();
          data.append("data" , window.editor.getValue());
          var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP"); 
          xhr.open( 'post', 'SaveToFile.php', true);
          xhr.send(data);

	// 	editor.save();

 //  		var code = document.getElementById("editor").value;
	// 	var resultFrame = document.getElementById("result");
	// 	var iWind = resultFrame.contentWindow;   // the iframe's window
 //     	console.log("iWind " + iWind);
 //     	console.log("ecco " + resultFrame.contentWindow.location.reload());
 //     	resultFrame.contentWindow.location.reload();
 //     	resultFrame = iWind.eval(code);
     
   
	 });
		

});

