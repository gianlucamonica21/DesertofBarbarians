$(document).ready(function(){

  var finishedCoding;
  $('#submitButton').click(function(){

   

  // scrittura su file modificato nell'editor
  var data = new FormData();
  data.append("data" , window.editor.getValue());
  var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
  xhr.open( 'post', 'SaveToFile.php', true);
  xhr.send(data);
  location.reload();
  //startLevel();

});

  $('#returnButton').click(function(){
    //nextFrame();
    if(stoppedGame){
     startLevel();
     stoppedGame = false;
   }
 });

  $('#evaluateButton').click(function(){

   finishedCoding = (new Date()).getTime();
   difference = startedCoding - finishedCoding;
   alert("Hai impiegato " + (-1*difference) + " millesimi di non so cosa per fornire la soluzione");


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
      oReq.open("get", "DBConnection/nextlevel.php", false);
        //                               ^ block the rest of the execution.
        //                                 Don't wait until the request finishes to 
        //                                 continue.
        oReq.send();
        alert("RISULTATO PRIMA CHIAMATA da defalut.js : "+ stringa);
        




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
        alert("RISULTATO SECONDA CHIAMATA da default.js :" + stringa);



        location.reload();
      }
      else
       alert("Valore sbagliato: riprova ancora");
   });



});
