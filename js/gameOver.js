


  function gameOver(){
    var intro = introJs();
    intro.setOptions({
      steps: [
      {
        intro: "<img src='img/general.png' class='image-general center-block'/> <br>" +
        " <h3>Great Job recruit!</h3>Thanks to your help, we managed to defeat the enemies, and have the means to resist any other attack!" 
              }
      ]
    });
    intro.start();
  }

