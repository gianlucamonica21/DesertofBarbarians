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
        
        //Query to update the level of the user
        var stringa;
        var oReq = new XMLHttpRequest(); //New request object
        oReq.onload = function() {
        //This is where you handle what to do with the response.
        //The actual data is found on this.responseText
        stringa = this.responseText; //Will alert: 42
        };
        oReq.open("get", "nextlevel.php", false);
        //                               ^ block the rest of the execution.
        //                                 Don't wait until the request finishes to 
        //                                 continue.
        oReq.send(); 


        //Code to reload and reupdate the level  
        var stringa;
        var oReq = new XMLHttpRequest(); //New request object
        oReq.onload = function() {
        //This is where you handle what to do with the response.
        //The actual data is found on this.responseText
        stringa = this.responseText; //Will alert: 42
        };
        oReq.open("get", "load_level.php", false);
        //                               ^ block the rest of the execution.
        //                                 Don't wait until the request finishes to 
        //                                 continue.
        oReq.send(); 



        location.reload();
}
else
 alert("Valore sbagliato: riprova ancora");
});



});
