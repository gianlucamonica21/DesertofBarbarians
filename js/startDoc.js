function startDoc(){
  var intro = introJs();
  //DOCUMENTATION LEVEL1
  var stringlev0 = "<h3></h3>";
  var stringlev1 = "<h3>Here some helps for you: </h3> <ol> <li>A JavaScript <b>function</b> is a block of code designed to perform a particular task, it takes input(ex. xDistance, yDistance) and return output/s; </li>";
  var stringlev1a = "<li> JavaScript <b>variables</b>(ex. speed) are containers for storing data values;</li>";
  var stringlev1b = "<li> <b>+</b> is the addition;</li><li> <b>/</b> is the division;</li><li> <b>=</b> is the assignment of a value to a variable;</li>"
  var stringlev1c= "<li><b>Math.sqrt()</b> and <b>Math.pow()</b> calculate respectively the square root and the power;</li>"
  var stringlev1d = "<li><b>return</b> is necessary to set the output of the function, if it does have.</li></ol>"
  //DOCUMENTATION LEVEL2
  var stringlev2 = "<h3>Here some helps for you: </h3> <ol> <li>Very often when you write code, you want to perform different actions for different decisions, indeed it is necessary to use the <b>if-then-else</b> statement; </li>";
  var stringlev2a = "<li> <b>&&</b> means the logic AND;</li>";
  var stringlev2b = "<li> <b>whichAntiMissileBattery</b> is a function MARGHERITA;</li>"
  var stringlev2c= "<li><b>playerMissiles.push(new Pla..)</b> is a function MARGHERITA.</li></ol>"
  //DOCUMENTATION LEVEL3
  var stringlev3 = "<h3>Here some helps for you: </h3> <ol> <li><b>for</b> is a tool which it is useful for loop. Loops can execute a block of code a number of times; </li>";
  var stringlev3a = "<li> <b>enemyMissiles.push(new ...)</b> is a function which MARGHERITA;</li>";
  var stringlev3b = "<li> <b>++</b>, <b>--</b> are increment/decrement operator, the first increments,the last decrements the value of a variable by one;</li>"
  var stringlev3c= "<li><b>playerMissiles.push(new Pla..)</b> is a function MARGHERITA.</li></ol>"
  //DOCUMENTATION LEVEL4
  var stringlev4 = "<h3>Here some helps for you: </h3> <ol> <li>The <b>array</b>s are used to store multiple values in a single variable; </li>";
  var stringlev4b = "<li> <b>antiMissileBatteries[1].missileLeft</b> is a MARGHERITA;</li>";
  var stringlev4a = "<li> <b>[1]</b>, is used to access  the first element of the array;</li>"
  var stringlev4c= "<li><b>.</b> &nbsp indicate that each element of the array has another variable as an attribute.</li></ol>"
 //DOCUMENTATION LEVEL5
  var stringlev5 = "<h3>Here some helps for you: </h3> <ol> <li>The <b>while</b> is a tool that can execute a block of code as long as a specified condition is true; </li>";
  var stringlev5a = "<li> <b>!=</b> mean unequality and <b>*</b> is the multiplication.</li>";
  var stringlev5b = "<li> <b>[1]</b>, is used to access  the first element of the array;</li>"
  var stringlev5c= "<li><b>.</b> &nbsp indicate that each element of the array has another variable as an attribute.</li></ol>"
//DOCUMENTATION LEVEL6
  var stringlev6 = "<h3>Here some helps for you: </h3> <ol> <li>The <b><,></b> mean less and greater of arithmetic; </li>";
  var stringlev6a = "<li> <b>x +=  y</b> mean x = x + y.</li>";
  var stringlev6b = "<li> <b>[1]</b>, is used to access  the first element of the array;</li>"
  var stringlev6c= "<li><b>.</b> &nbsp indicate that each element of the array has another variable as an attribute.</li></ol>"
//DOCUMENTATION LEVEL7
  var stringlev7 = "<h3>I am sorry, I have no more knowledges! </h3>";
//DOCUMENTATION LEVEL8
  var stringlev8 = "<h3>I already told you! I can not do more!</h3> <ol>";
//DOCUMENTATION LEVEL9
  var stringlev9 = "<h3>Have you seen!? You can do it alone! DO IT! DO IT!</h3>";
 
  switch(level){
      case 1:
      {
            intro.setOptions({
                  steps: [
                //   {
                //       intro: "This is the documentation. It will help you sooo much! "
                // },
                {
                      element: document.querySelector('#editorpanel'),
                      intro: "<img src='img/ghost.png' class='image-general center-block'/> <br>" + "HI!!! I am the ghost of the lead developer passed away a long time ago, i will help you in this mission!" + stringlev0 + stringlev1 + stringlev1a + stringlev1b + stringlev1c + stringlev1d,
                      position: 'right'
                },
                 
      
      ]
});

            break;
      }
      case 2:
      {

intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro: "<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev2 + stringlev2a + stringlev2b + stringlev2c,
                      position: 'right'
                }


      ]
    });








            break;
      }
      case 3:
      {
            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev3 + stringlev3a + stringlev3b + stringlev3c,
                      position: 'right'
                }


      ]
    });



            break;
      }
      case 4:
      {

            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev4 + stringlev4a + stringlev4b + stringlev4c,
                      position: 'right'
                }


      ]
    });
            break;
      }
      case 5:
      {

            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev5 + stringlev5a ,
                      position: 'right'
                }


      ]
    });

            break;
      }
      case 6:
      {

            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro: "<img src='img/ghost.png' class='image-general center-block'/> <br>" +stringlev6 + stringlev6a  ,
                      position: 'right'
                }


      ]
    });
            break;
      }
      case 7:
      {

            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev7  ,
                      position: 'right'
                }


      ]
    });
            break;
      }
      case 8:
      {
       
            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev8  ,
                      position: 'right'
                }


      ]
    });
            break;
      }
      case 9:
      {
       
            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev9 ,
                      position: 'right'
                }


      ]
    });
            break;
      }
}

































intro.start();
}
