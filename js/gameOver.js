


  function gameOver(){
    var intro = introJs();
    intro.setOptions({
      steps: [
      {
        intro: "<img src='img/general.png' class='image-general center-block'/> <br>" +
        " <h3>Congratulations!!</h3><h3>You have defeated the enemies and completed the game!</h3>" 
              }
      ]
    });
    intro.start();
  }

