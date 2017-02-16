
  function startLevelNotPassed(){
    var intro = introJs();
    intro.setOptions({
      steps: [
      {
        element: document.querySelector('.dochint'),


        position: "top",
        intro: "<img src='img/general.png' class='image-general center-block'/> <br>" +
        " <h3>Your solution was incorrect! You <b>can't</b> go to the next level! Try again. <br> If you need more help you may ask to the <b>assistant</b>. If you are really stuck, try asking to the <b>ghost</b>! (If it really exists...)</h3>"  
           }
  
      ]
    });
    intro.start();
  }
