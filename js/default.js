$(document).ready(function(){

	$('#submitButton').click(function(){


  // scrittura su file modificato nell'editor
  var data = new FormData();
  data.append("data" , window.editor.getValue());
  var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP"); 
  xhr.open( 'post', 'SaveToFile.php', true);
  xhr.send(data);
  location.reload();


});

	$('#evaluateButton').click(function(){


		try{
			var test = userSolutionChecker();
     // scrittura su file modificato nell'editor
     var data = new FormData();
     data.append("data" , window.editor.getValue());
     var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP"); 
     xhr.open( 'post', 'SaveToFile.php', true);
     xhr.send(data);
     location.reload();
 }
 catch(err){
        // var test = getTest();
    }

    if (test == true){
    	alert ("Livello passato!"); 
      // query per incrementare livello dell' utente 

      
        // var data = new FormData();
        // data.append("data" , window.editor.getValue());
        // var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
        // xhr.open( 'post','next_level.php', false);
        // xhr.send(data);
        location.reload();
    }
    else
    	alert("Valore sbagliato: riprova ancora");
});


	
});

