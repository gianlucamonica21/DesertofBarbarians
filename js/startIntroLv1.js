


  function startIntroLv1(){
    var intro = introJs();
    intro.setOptions({
      steps: [
      {
        element: document.querySelector('#nextButton'),
        position: 'top',
        intro: "<img src='img/general.png' class='image-general center-block'/> <br>" +
        " <h3>When you passed a level after you click the evaluate button it will appear this!Click here to go to the next level!</h3>"  
           }
  
      ]
    });
    intro.start();
  }

