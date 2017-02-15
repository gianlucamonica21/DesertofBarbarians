
  function startLevelPassed(){
    var intro = introJs();
    intro.setOptions({
      steps: [
      {
            
        intro: "<img src='img/general.png' class='image-general center-block'/> <br>" +
        " <h3>Level passed! You <b>can go</b> to the next level!</h3>"  
           }
  
      ]
    });
    intro.start();
  }
