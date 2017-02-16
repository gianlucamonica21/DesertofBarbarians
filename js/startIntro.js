


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
        element: document.querySelector('#miscom'),
        position: 'left',
        intro: "This is the simulator, check it and play it to observe your updates!"
      },
      {
        element: document.querySelector('#editorpanel'),
        intro: "This is where you code to fix the bugs!<br>REMEMBER: when you start coding the simulator will pause!",
        position: 'right'
      },
      {
        element: document.querySelector('#miscom'),
        intro: 'Reclick here to resume the simulator from the pause!',
        position: 'left'
      },
      {
        element: document.querySelector('#chat'),
        intro: 'This is the chat! Obey orders and listen the helps of the general.',
        position: 'right'
      },
      {
        element: document.querySelector('#submitButton'),
        intro: 'Click here to update the simulator code!',
        position: 'top'
      },
        {
        element: document.querySelector('#miscom'),
        intro: 'Play it to verify the changes!',
        position: 'left'
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
        element: document.querySelector('#evaluateButton'),
        intro: 'Click here to evaluate your code, if the solution is right you will go to the next level! Until you do not click the execute button this button will be locked!',
        position: 'top'
      },
      {
        element: document.querySelector('#nextButton'),
        intro: 'When you pass a level this button will appear,click to go to the next level!',
        position: 'left'
      },
      {
        element: document.querySelector('#lev'),
        intro: 'This is your current level!',
        position: 'bottom'
      },
      {
        element: document.querySelector('#timebarlv2'),
        intro: 'This is the next level! It is not yet unlocked!',
        position: 'right'
      },
      {
        element: document.querySelector('.col-md-12'),
        intro: 'This bar shows you the locked and unlocked levels! The animated bar indicate your current level! Click the unlocked levels you want to play!<br>REMEMBER: click the number, not the bar!',
        position: 'down'
      },

      

      {
        element: document.querySelector('#timebarlv9'),
        intro: 'The more you pass the levels the more this bar will fill, until you reach the last level. The levels will be colored with a different color according to the type of the problem to solve.',
        position: 'down'
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
        element: document.querySelector('#displayscorerank'),
        intro: 'Here you see your rank, your score and a bar displaying how close you are to the next rank!',
        position: 'bottom'
      },
      {
        element: document.querySelector('#profileTutorial'),
        intro: 'Click here to watch closer your statistics, your badges and your wonderful avatar!',
        position: 'bottom'
      },
      {
        element: document.querySelector('#leaderboardTutorial'),
        intro: 'Click here to watch the highest scores list! Check your presence!',
        position: 'bottom'
      },

      {
        element: document.querySelector('#bye'),
        intro: 'Click here to logout! Bye :(',
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

