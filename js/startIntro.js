  function startIntro(){
    var intro = introJs();
    intro.setOptions({
      steps: [
      {
        intro: "<img src='img/general.png' class='image-general center-block'/> <br>" +
        " <h3>Welcome to the Bastiani Fortress, recruit!</h3>" + 
        "I am General Drogo, and I have been guarding this encampment for many years from the barbarian horde rumored to live beyond this desert. I had begun to believe it was just that - a rumor. But now, after decades, suddenly the horde has decided to attack our old and unmaintaned fortress. And let me tell you - they are not the kind of barbarian horde you see in the movies, recruit. They have missiles, and an automated system which is light years ahead of ours. Our old lead developer is long gone now, so we need someone to fix and update our anti-missile system quickly before our camp is completely destroyed. You have been called here because you are the only one who knows anything about this new technology and programming stuff. Our survival depends on you, recruit! "
      }
      ,
      {
        element: document.querySelector('#chat'),
        intro: 'This is the chat! Obey orders and listen the helps of the general.',
        position: 'right'
      },
      {
        element: document.querySelector('#hintButton'),
        intro: "If you are stuck, you can ask for help to a soldier which had been assigned as our old lead developer's assistant. Maybe he has more of an idea on how the system works! Try clicking more than ones for different hints!",
        position: 'top'
      },
      {
        element: document.querySelector('#docButton'),
        intro: 'There is a rumour around! The ghost of the lead developer passed away long time ago is back in town! Ask him for further information, it sound weird but why you shouldn\'t try? ',
        position: 'top'
      },
      {
        element: document.querySelector('#editorpanel'),
        intro: "This is where you code to fix the bugs!<br>REMEMBER: when you start coding the simulator will pause!",
        position: 'right'
      },
      {
        element: document.querySelector('#submitButton'),
        intro: 'Click here to update the simulator code!',
        position: 'top'
      },
      {
        element: document.querySelector('#evaluateButton'),
        intro: 'Click here to evaluate your code, if the solution is right you will go to the next level! Until you do not click the execute button this button will be locked!',
        position: 'top'
      },
      {
        element: document.querySelector('#refreshButton'),
        intro: 'Click here to reste the code. Careful, your changes will be lost!',
        position: 'top'
      },
      {
        element: document.querySelector('#miscom'),
        position: 'left',
        intro: "This is the simulator, check it and play it to observe your updates!"
      },
      {
        element: document.querySelector('#playButton'),
        intro: 'Click here to play or resume the simulator from the pause!',
        position: 'left'
      },
        {
        element: document.querySelector('#pauseButton'),
        intro: 'Click here to pause the simulator!',
        position: 'left'
      },
      {
        element: document.querySelector('.col-md-12'),
        intro: 'This bar shows you the locked and unlocked levels! The animated bar indicates your current level! Click the unlocked levels you want to play!',
        position: 'down'
      },
      {
        element: document.querySelector('#displayscorerank'),
        intro: 'Here you see your rank, your score and a bar displaying how close you are to the next rank!',
        position: 'bottom'
      },
      {
        intro: "<img src='img/general.png' class='image-general center-block'/> <br>" +
        "Now that you know how everything works, get to work recruit! Good luck!"
      }
      
      ]
    });
    intro.start();
  }

