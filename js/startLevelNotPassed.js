
  function startLevelNotPassed(){
    var intro = introJs();
    intro.setOptions({
      steps: [
      {
        element: document.querySelector('.dochint'),


        position: "top",
        intro: "<img src='img/general.png' class='image-general center-block'/> <br>" +
        " <h3>Level not passed! You <b>can not</b> go to the nextlevel! </h3><h3>If you need more help you may ask to the <b>old assistant</b>.</h3><h3> If you are really stuck, try asking to the <b>ghost</b>!(if it really exists)</h3>"  
           }
  
      ]
    });
    intro.start();
  }
