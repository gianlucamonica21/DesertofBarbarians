


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
        position: 'left',
        intro: "This is where you will receive your instructions and/or hints."
      },
      {
        element: document.querySelector('#editorpanel'),
        intro: "This is where you code to fix the bugs!",
        position: 'right'
      },
      {
        element: document.querySelector('#gamepanel'),
        intro: 'This is the game, play to see your changes!',
        position: 'left'
      },
      {
        element: document.querySelector('#submitButton'),
        intro: 'Click here to update the game code!',
        position: 'top'
      },
      {
        element: document.querySelector('#evaluateButton'),
        intro: 'Click here to evaluate your code, if the solution is right you will go to the next level!',
        position: 'top'
      },
      {
        element: document.querySelector('#refreshButton'),
        intro: 'Click here to remove your last updates in the code!',
        position: 'top'
      },
      {
        element: document.querySelector('#hintButton'),
        intro: "If you are stuck, you can ask for help to a soldier which had been assigned as our old lead developer's assistant. Maybe he has more of an idea on how the system works!",
        position: 'top'
      },
      {
        element: document.querySelector('#docButton'),
        intro: 'Click here to read the surviving documentation!',
        position: 'top'
      },
      {
        element: document.querySelector('#returnButton'),
        intro: 'Click here to resume the game from the pause!',
        position: 'top'
      },
      {
        element: document.querySelector('#profileTutorial'),
        intro: 'Click here to view your statistics!',
        position: 'bottom'
      },
      {
        element: document.querySelector('#levelsTutorial'),
        intro: 'Click here to view the locked and unlocked levels!',
        position: 'bottom'
      },
      {
        element: document.querySelector('#leaderboardTutorial'),
        intro: 'Click here to view the leaderboard, check your ranking!',
        position: 'bottom'
      },
      {
        element: document.querySelector('#logoutTutorial'),
        intro: 'Click here to logout :(',
        position: 'bottom'
      },
      {
        element: document.querySelector('#tutorialbutton'),
        intro: 'Click here if you want to see the tutorial again!',
        position: 'bottom'
      }

      ]
    });
    intro.start();
  }

