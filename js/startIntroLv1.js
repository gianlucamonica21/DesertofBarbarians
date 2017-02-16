


  function startIntroLv1(){
    var intro = introJs();
    intro.setOptions({
      steps: [
      {
        element: document.querySelector('#nextButton'),
        position: 'top',
        intro: "<img src='img/general.png' class='image-general center-block'/> <br>" +
        " <h3>When you click evaluate, if your solution is correct this button will appear.Click it to go to the next level!</h3>"  
           }
  
      ]
    });
    intro.start();
  }

